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

// Route::get('/', function () {
//     return view('welcome');
// });

//Customer Web Routes
Route::get('/', 'CustomerController@index');
Route::get('/customer-register', function () {
    session(['menu_customer' => 'register']);
    return view('customer.register');
});
Route::post('/customer-register', 'CustomerController@register');
Route::get('/customer-login', function () {
    session(['menu_customer' => 'login']);
    return view('customer.login');
});
Route::post('/customer-login', 'CustomerController@login');
Route::get('/customer-logout', 'CustomerController@logout');
Route::get('/my-cart', 'CustomerController@my_cart')->middleware('customer');
Route::get('/my-cart-update/{id}/{qty}', 'CustomerController@my_cart_update')->middleware('customer');
Route::get('/my-cart-checkout', 'CustomerController@my_cart_checkout')->middleware('customer');
Route::get('/history-transaction', 'CustomerController@history_transaction')->middleware('customer');
Route::get('/history-transaction-detail/{id}', 'CustomerController@history_transaction_detail')->middleware('customer');
Route::get('/customer-change-password', 'CustomerController@change_pass')->middleware('customer');
Route::post('/customer-change-password', 'CustomerController@change_pass_customer')->middleware('customer');
Route::get('/categories/{id}', 'CustomerController@categories');
Route::post('/categories/{id}', 'CustomerController@categories');
Route::get('/categories-product/{id}', 'CustomerController@categories_product');
Route::post('/categories-product-add-cart', 'CustomerController@categories_product_add_cart');


//Manager Web Routes
Route::get('/manager-login', 'ManagerController@index');
Route::post('/manager-login', 'ManagerController@login');
Route::get('/manager-logout', 'ManagerController@logout')->middleware('manager');
Route::get('/manager-home', 'ManagerController@home')->middleware('manager');
Route::get('/manager-add-flower', 'ManagerController@create_flower')->middleware('manager');
Route::post('/manager-add-flower', 'ManagerController@create_flower_store')->middleware('manager');
Route::get('/manager-categories', 'ManagerController@manage_categories')->middleware('manager');
Route::get('/manager-categories-create', 'ManagerController@manager_categories_create')->middleware('manager');
Route::post('/manager-categories-create', 'ManagerController@manager_categories_store')->middleware('manager');
Route::get('/manager-categories-edit/{id}', 'ManagerController@manager_categories_edit')->middleware('manager');
Route::post('/manager-categories-update', 'ManagerController@manager_categories_update')->middleware('manager');
Route::get('/manager-categories-delete/{id}', 'ManagerController@manager_categories_delete')->middleware('manager');
Route::get('/manager-change-password', 'ManagerController@change_pass')->middleware('manager');
Route::post('/manager-change-password', 'ManagerController@change_pass_manager')->middleware('manager');
Route::get('/manager-categories-product/{id}', 'ManagerController@categories_all')->middleware('manager');
Route::post('/manager-categories-product/{id}', 'ManagerController@categories_all')->middleware('manager');
Route::get('/manager-categories-product-edit/{id}', 'ManagerController@categories_produk')->middleware('manager');
Route::post('/manager-categories-product-update', 'ManagerController@categories_product_update')->middleware('manager');
Route::get('/manager-categories-product-delete/{id}', 'ManagerController@categories_product_delete')->middleware('manager');
