<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        for ($i = 1; $i <= 1000; $i++) {

            $data[] = [
                'id' => $i,
                'name' => Str::random(5),
                'email' => Str::random(8) . '@z.ru',
                'gender' => rand(1, 2) == 1 ? 'male' : 'female',
                'age' => rand(18, 45),
            ];
        }

        \DB::table('test_users')->insert($data);
    }
}
