<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::post('user/create', 'Api\UserController@create');

Route::get('/test', function () {
    p("working");
});


Route::post('user/store', 'App\Http\Controllers\Api\UserController@store');
Route::get('user/get/{flag}', [UserController::class, 'index']);
Route::get('user/{id}', [UserController::class, 'show']);
Route::get('showallusers', [UserController::class, 'showallusers']);
Route::delete('user/delete/{id}', [UserController::class, 'destroy']);
Route::put('user/update/{id}', [UserController::class, 'update']);
Route::patch('user/change_password/{id}', [UserController::class, 'changepassword']);