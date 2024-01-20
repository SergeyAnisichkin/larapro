<?php

namespace App\Domain\Repositories\Main\User;

use App\Domain\Entities\User\User;
use App\Domain\Enums\User\UserRole;
use App\Models\Role;
use App\Models\User as UserModel;
use App\Models\UserRole as UserRoleModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserCommandRepository
{
    public function create(User $user): int
    {
        DB::transaction(static function () use ($user): void {
            $userModel = UserModel::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'uuid' => $user->getUuid(),
                'password' => Hash::make($user->getPassword()),
            ]);

            /** @var UserRole $role */
            foreach ($user->getRoles() as $role) {
                $roleModel = Role::query()->firstWhere('name', $role->value);

                if ($roleModel === null) {
                    continue;
                }
                UserRoleModel::firstOrCreate([
                    'user_id' => $userModel->id,
                    'role_id' => $roleModel->id,
                ]);
            }

            $user->setId($userModel->id);
        });

        return $user->getId();
    }

    public function update(User $user): void
    {
        UserModel::update([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => Hash::make($user->getPassword()),
        ]);
    }
}