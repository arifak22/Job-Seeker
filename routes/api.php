<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Helpers\Sideveloper;
Sideveloper::routeController('/auth','Api\AuthController');

Route::middleware(['jwt.verify'])->group(function () {
    Sideveloper::routeController('/pencari-kerja','Api\PencarikerjaController');
    Sideveloper::routeController('/perusahaan','Api\PerusahaanController');
    Sideveloper::routeController('/admin','Api\AdminController');
    Sideveloper::routeController('/master','Api\MasterController');
});

Route::middleware(['jwt.dynamic.verify'])->group(function () {
    Sideveloper::routeController('/option','Api\OptionController');
    Sideveloper::routeController('/services','Api\ServicesController');
    Sideveloper::routeController('/menu','Api\MenuController');
});