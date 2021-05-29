<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/** Admin side ------------ */
Route::group(['middleware' => ['status','auth']], function () {
    $groupeData = [
        'namespace' => 'App\Http\Controllers\Shop\Admin',
        'prefix' => 'admin',
    ];
    Route::group($groupeData, function () {
        Route::resource('index', 'MainController')
            ->names('shop.admin.index');

        Route::resource('orders', 'OrderController')
            ->names('shop.admin.orders');
        Route::get('/orders/change/{id}','OrderController@change')
            ->name('shop.admin.orders.change');
        Route::post('/orders/save/{id}','OrderController@save')
            ->name('shop.admin.orders.save');
        Route::get('/orders/forcedestroy/{id}','OrderController@forcedestroy')
            ->name('shop.admin.orders.forcedestroy');

        Route::get('/categories/mydel','CategoryController@mydel')
            ->name('shop.admin.categories.mydel');

        $methods = ['index','edit','update','create','store', 'destroy','mydel'];
        Route::resource('categories', 'CategoryController')
            ->names('shop.admin.categories');

        Route::resource('users','UserController')
            ->names('shop.admin.users');

        Route::resource('products','ProductController')
            ->names('shop.admin.products');

    });
});
//-------------------------

// User side
$groupeData = [
    'namespace' => 'App\Http\Controllers\Shop\User',
    'prefix' => 'user',
];
Route::group($groupeData, function () {
    Route::resource('index', 'MainController')
        ->names('shop.user.index');
});
//---------

//Disabled side - in that moment don`t work yet
$groupeData = [
    'namespace' => 'App\Http\Controllers\Shop\Disabled',
    'prefix' => 'disabled',
];
Route::group($groupeData, function () {
    Route::resource('index', 'MainController')
        ->names('shop.disabled.index');
});


//>  Blog Admin ------------------------
Route::group(['namespace' => 'App\Http\Controllers\Blog', 'prefix' => 'blog'], function () {
    Route::resource('posts', 'PostController')->names('blog.posts');
});

$groupData = [
    'namespace' => 'App\Http\Controllers\Blog\Admin',
    'prefix' => 'admin/blog',
];
Route::group($groupData, function () {
    // BlogCategory
    $methods = ['index', 'edit', 'update', 'create', 'store', ];
    Route::resource('categories', 'CategoryController')
        ->only($methods)
        ->names('blog.admin.categories');

    // BlogPost
    Route::resource('posts', 'PostController')
        ->except(['show'])
        ->names('blog.admin.posts');
});
//<


//Route::resource('rest', 'App\Http\Controllers\RestTestController')->names('restTest');


