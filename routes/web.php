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

        Route::get('/products/related','ProductController@related');

        Route::match(['get', 'post'], '/products/ajax-image-upload', 'ProductController@ajaxImage');
        Route::delete('/products/ajax-remove-image/{filename}', 'ProductController@deleteImage');
        Route::post('/products/gallery','ProductController@gallery')
            ->name('shop.admin.products.gallery');
        Route::post('/products/delete-gallery','ProductController@deleteGallery')
            ->name('shop.admin.products.deletegallery');

        Route::get('/products/return-status/{id}','ProductController@returnStatus')
            ->name('shop.admin.products.returnstatus');
        Route::get('/products/delete-status/{id}','ProductController@deleteStatus')
            ->name('shop.admin.products.deletestatus');
        Route::get('/products/delete-product/{id}', 'ProductController@deleteProduct')
            ->name('shop.admin.products.deleteproduct');

        Route::get('/filter/group-filter', 'FilterController@attributeGroup');
        Route::get('/filter/group-add', 'FilterController@attributeGroup');
        Route::get('/filter/group-delete/{id}', 'FilterController@groupDelete');
        Route::match(['get','post'],'/filter/group-add-group', 'FilterController@groupAdd');
        Route::match(['get','post'],'/filter/group-edit/{id}','FilterController@groupEdit');
        Route::get('/filter/attributes-filter', 'FilterController@attributeFilter');
        Route::match(['get','post'],'/filter/attrs-add', 'FilterController@attributeAdd');
        Route::get('/filter/attr-delete/{id}', 'FilterController@attrDelete');
        Route::match(['get','post'],'/filter/attr-edit/{id}','FilterController@attrEdit');

        Route::get('/currency/index','CurrencyController@index');
        Route::match(['get','post'],'/currency/add','CurrencyController@add');
        Route::match(['get','post'],'/currency/edit/{id}','CurrencyController@edit');
        Route::get('/currency/delete/{id}','CurrencyController@delete');

        Route::get('/search/result', 'SearchController@index');
        Route::get('/autocomplete', 'SearchController@search');

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


