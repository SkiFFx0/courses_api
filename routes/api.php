<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request)
{
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function ()
{
    Route::group(['prefix' => 'users'], function (){
        Route::patch('/', [UserController::class, 'update']);

        Route::patch('/change-password', [UserController::class, 'updatePassword']);
    });

    Route::group(['prefix' => 'courses'], function ()
    {
        Route::post('/', [CourseController::class, 'store']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
