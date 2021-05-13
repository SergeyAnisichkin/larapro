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

    });
});
//---------



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


