<?php

use App\Http\Controllers\Api\AccountsController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('manage')->group(function(){

    Route::prefix('accounts')->group(function(){
        Route::get('/', [AccountsController::class, 'index']);
        Route::get('/show/{id}', [AccountsController::class, 'show']);
        Route::post('/create', [AccountsController::class, 'create']);
        Route::post('/update/{id}', [AccountsController::class, 'update']);
        Route::delete('/delete/{id}', [AccountsController::class, 'destroy']);
    });
});


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', [AuthController::class, 'me']);

});
