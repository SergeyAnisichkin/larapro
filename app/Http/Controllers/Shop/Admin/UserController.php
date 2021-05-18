<?php

    namespace App\Http\Controllers\Shop\Admin;

    use App\Http\Requests\AdminUserEditRequest;
    use App\Models\Role;
    use App\Models\UserRole;
    use App\Repositories\Admin\MainRepository;
    use App\Repositories\Admin\UserRepository;
    use MetaTag;
    use App\Models\Admin\User;

    class UserController extends AdminBaseController
    {
        private $userRepository;

        public function __construct()
        {
            parent::__construct();
            $this->userRepository = app(UserRepository::class);
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\View\View
         */
        public function index()
        {
            $perPage = 8;
            $countUsers = MainRepository::getCountUsers();
            $paginator = $this->userRepository->getAllUsers($perPage);

            MetaTag::setTags(['title' => 'Список пользователей']);

            return view('shop.admin.user.index',
                compact('countUsers', 'paginator'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Contracts\View\View
         */
        public function create()
        {
            MetaTag::setTags(['title' => 'Добавление пользователя']);

            return view('shop.admin.user.add');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param AdminUserEditRequest $request
         * @param UserRole $role
         * @return \Illuminate\Http\RedirectResponse
         */
        public function store(AdminUserEditRequest $request)
        {

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password'])
            ]);

            if (!$user) {
                return back()
                    ->withErrors(['msg' => "Ошибка создания"])
                    ->withInput();
            } else {
                $role = UserRole::create([
                    'user_id' => $user->id,
                    'role_id' => (int)$request['role'],
                ]);
                if (!$role) {
                    return back()
                        ->withErrors(['msg' => "Ошибка создания Роли пользователя"])
                        ->withInput();
                } else {
                    return redirect()
                        ->route('shop.admin.users.edit', $user->id)
                        ->with(['success' => 'Успешно создан']);
                }
            }
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Contracts\View\View
         */
        public function edit($id)
        {
            $perPage = 10;
            $item = $this->userRepository->getEditId($id);
            if (empty($item)) {
                abort(404);
            }

            $orders = $this->userRepository->getUserOrders($id, $perPage);
            $role = $this->userRepository->getUserRole($id);
            $count = $this->userRepository->getCountOrdersPag($id);
            $count_orders = $this->userRepository->getCountOrders($id, $perPage);

            MetaTag::setTags(['title' => "Редактирование профиля пользователя № {$item->id}"]);

            return view('shop.admin.user.edit',
                compact('item', 'orders', 'role', 'count_orders', 'count'));
        }


        /**
         * Update the specified resource in storage.
         *
         * @param AdminUserEditRequest $request
         * @param \App\Models\Admin\User $user
         * @param \App\Models\UserRole $role
         * @return \Illuminate\Http\RedirectResponse
         */
        public function update(AdminUserEditRequest $request, User $user, UserRole $role)
        {
            $user->name = $request['name'];
            $user->email = $request['email'];
            $request['password'] == null ?: $user->password = bcrypt($request['password']);
            $save = $user->save();
            if (!$save) {
                return back()
                    ->withErrors(['msg' => "Ошибка сохранения"])
                    ->withInput();
            } else {
                $role->where('user_id', $user->id)->update(['role_id' => (int)$request['role']]);
                return redirect()
                    ->route('shop.admin.users.edit', $user->id)
                    ->with(['success' => 'Успешно сохранено']);
            }

        }


        /**
         * Remove the specified resource from storage.
         * @param User $user
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function destroy(User $user)
        {
            $result = $user->forceDelete();
            if($result){
                return redirect()
                    ->route('shop.admin.users.index')
                    ->with(['success' => "Пользователь " . ucfirst($user->name) . " удален"]);
            } else {
                return back()->withErrors(['msg' => 'Ошибка удаления']);
            }
        }
    }
