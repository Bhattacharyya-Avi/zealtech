<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login',[LoginController::class,'login'])->name('login');


Route::group(['middleware'=>['auth:api']],function(){

    Route::get('/users',[UserController::class,'userList'])->name('user.list');
    Route::controller(ProductController::class)->group(function(){
        Route::get('/list','list');
        Route::post('/create','create');
        Route::post('/update/{id}','update');
        Route::get('/delete/{id}','delete');
    });
});

