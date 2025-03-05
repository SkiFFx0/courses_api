<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function ()
{
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'users'], function ()
    {
        Route::patch('/', [UserController::class, 'update']);

        Route::patch('/change-password', [UserController::class, 'updatePassword']);

        Route::delete('/', [UserController::class, 'destroy']);
    });

    Route::group(['prefix' => 'admin'], function ()
    {
        Route::middleware(['role.admin', 'auth-sanctum'])->group(function ()
        {
            Route::post('/assign-role/{user}', [AdminController::class, 'assignRole']);

            Route::delete('/delete-user/{user}', [AdminController::class, 'destroy']);
        });
    });

    Route::middleware(['role.teacher'])->group(function ()
    {
        Route::group(['prefix' => 'courses'], function ()
        {
            Route::post('/', [CourseController::class, 'store']);

            Route::patch('/{course}', [CourseController::class, 'update']);

            Route::delete('/{course}', [CourseController::class, 'destroy']);
        });

        Route::group(['prefix' => 'tasks'], function ()
        {
            Route::post('/{course}', [TaskController::class, 'store']);

            Route::patch('/{task}', [TaskController::class, 'update']);

            Route::delete('/{task}', [TaskController::class, 'destroy']);
        });
    });
});
