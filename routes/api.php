<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AmbassadorController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\OrdersController;

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

function common($scope){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', $scope])->group(function(){
        Route::get('user', [AuthController::class, 'user']);
        Route::post('update_info', [AuthController::class, 'updateInfo']);
        Route::post('update_password', [AuthController::class, 'updatePassword']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
}

Route::prefix('admin')->group( function(){

    common('scope.admin');

    Route::middleware(['auth:sanctum', 'scope.admin'])->group(function(){

        Route::get('ambassadors', [AmbassadorController::class, 'index']);
        Route::get('user/{id}/links', [LinksController::class, 'index']);
        Route::get('orders', [OrdersController::class, 'index']);
        Route::apiResource('products', ProductsController::class);
        
    });

});

//Ambassador //Ambassador //Ambassador
Route::prefix('ambassador')->group( function(){

    common('scope.ambassador');

    Route::middleware(['auth:sanctum', 'scope.ambassador'])->group(function(){

        
    });

});
