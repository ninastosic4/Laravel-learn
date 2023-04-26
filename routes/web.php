<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

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

// USERS MODUL START
Route::get('/users', 'Admin\UsersController@index')->name('users.index');
Route::get('/users/login', 'Admin\UsersController@login')->name('users.login');
Route::post('/users/login', 'Admin\UsersController@login')->name('users.login.post');
Route::get('/users/welcome', 'Admin\UsersController@welcome')->name('users.welcome');
Route::get('/users/create', 'Admin\UsersController@create')->name('users.create');
Route::post('/users/store', 'Admin\UsersController@store')->name('users.store');
Route::get('/users/{user}/edit', 'Admin\UsersController@edit')->name('users.edit');
Route::post('/users/{user}/update', 'Admin\UsersController@update')->name('users.update');
Route::get('/users/{user}/changepassword', 'Admin\UsersController@changepassword')->name('users.changepassword');
Route::post('/users/{user}/changepassword', 'Admin\UsersController@changepasswordpost')->name('users.changepasswordpost');

Route::get('/users/forgot-password', 'Admin\UsersController@forgotpassword')->name('users.forgotpassword');
Route::post('/users/forgot-password', 'Admin\UsersController@forgotpasswordpost')->name('users.forgotpasswordpost');

Route::get('/users/password/reset/{token}', 'Admin\UsersController@passwordreset')->name('users.passwordreset');
Route::post('/users/password/reset', 'Admin\UsersController@passwordresetpost')->name('users.passwordresetpost');

Route::get('/users/{user}/status', 'Admin\UsersController@status')->name('users.status');
Route::get('/users/{user}/delete', 'Admin\UsersController@delete')->name('users.delete');
Route::get('/users/logout', 'Admin\UsersController@logout')->name('users.logout');
// USERS MODUL 


// CATEGORIES MODUL START
Route::get('/categories', 'Admin\CategoriesController@index')->name('categories.index');
Route::get('/categories/create', 'Admin\CategoriesController@create')->name('categories.create');
Route::post('/categories/store', 'Admin\CategoriesController@store')->name('categories.store');
Route::get('/categories/{category}/edit', 'Admin\CategoriesController@edit')->name('categories.edit');
Route::post('/categories/{category}/update', 'Admin\CategoriesController@update')->name('categories.update');

Route::get('/categories/{category}/status', 'Admin\CategoriesController@status')->name('categories.status');
Route::get('/categories/{category}/delete', 'Admin\CategoriesController@destroy')->name('categories.destroy');
// CATEGORIES MODUL END