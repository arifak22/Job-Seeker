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

use App\Helpers\Sideveloper;
Route::get('/',function(){
	return redirect('/home');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});


Sideveloper::routeController('/auth','AuthController');
Route::post('auth', [ 'as' => 'auth', 'uses' => 'AuthController@getIndex']);

Sideveloper::routeController('/home','HomeController');
Route::post('home', [ 'as' => 'home', 'uses' => 'HomeController@getIndex']);

Sideveloper::routeController('/option','OptionController');
Sideveloper::routeController('/menu','MenuController');

Route::middleware(['auth','access'])->group(function () {
	Sideveloper::routeController('/pencari-kerja','PencarikerjaController');
	Sideveloper::routeController('/perusahaan','PerusahaanController');
	Sideveloper::routeController('/admin','AdminController');
});