<?php

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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/post', 'PostController@post');
Route::get('/profile', 'ProfileController@profile');
Route::get('/category', 'CategoryController@category');
Route::post('/addCategory', 'CategoryController@addCategory');
Route::post('/addProfile', 'ProfileController@addProfile');
Route::post('/addPost', 'PostController@addPost');
Route::get('/view/{id}', 'PostController@view');
Route::get('/edit/{id}', 'PostController@edit');
Route::post('/editPost/{id}', 'PostController@editPost');
Route::get('/delete/{id}', 'PostController@deletePost');
Route::get('/dashboard', 'DashBoardController@dashboard');
Route::get('/getDashboard', 'DashBoardController@getDashboard');
Route::get('/editU/{id}', 'ProfileController@edit');
Route::post('/editUser/{id}', 'ProfileController@editUser');
Route::get('/deleteU/{id}', 'ProfileController@deleteUser');
