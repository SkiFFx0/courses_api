<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\SubmissionController;
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
        Route::middleware(['role.admin'])->group(function ()
        {
            Route::post('/assign-role/{user}', [AdminController::class, 'assignRole']);

            Route::delete('/delete-user/{user}', [AdminController::class, 'destroyUser']);

            Route::delete('/delete-course/{course}', [AdminController::class, 'destroyCourse']);
        });
    });

    Route::middleware(['permission:manage courses'])->group(function ()
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

    Route::group(['prefix' => 'enrollments'], function ()
    {
        Route::middleware(['role.student'])->group(function ()
        {
            Route::post('/{course}', [EnrollmentController::class, 'store']);

            Route::delete('/{course}', [EnrollmentController::class, 'destroy']);
        });

        Route::middleware(['permission:manage students'])->group(function ()
        {
            Route::post('/{course}/{student}', [EnrollmentController::class, 'storeStudent']);

            Route::delete('/{course}/{student}', [EnrollmentController::class, 'destroyStudent']);
        });
    });

    Route::group(['prefix' => 'grade'], function ()
    {
        Route::middleware(['permission:grade submissions'])->group(function ()
        {
            Route::patch('/enrollment/{enrollment}', [EnrollmentController::class, 'gradeEnrollment']);

            Route::patch('/submission/{submission}', [SubmissionController::class, 'gradeSubmission']);
        });
    });

    Route::middleware(['role.student'])->group(function ()
    {
        Route::group(['prefix' => 'enrollments'], function ()
        {
            Route::post('/{course}', [EnrollmentController::class, 'store']);

            Route::delete('/{course}', [EnrollmentController::class, 'destroy']);
        });

        Route::group(['prefix' => 'submissions'], function ()
        {
            Route::post('/{task}', [SubmissionController::class, 'store']);

            Route::delete('/{submission}', [SubmissionController::class, 'destroy']);
        });
    });

    Route::middleware(['permission:manage comments'])->group(function ()
    {
        Route::group(['prefix' => 'comments'], function ()
        {
            Route::post('/{commentableType}/{commentableId}', [CommentController::class, 'store'])
                ->whereIn('commentableType', ['course', 'submission']);

            Route::patch('/{comment}', [CommentController::class, 'update']);

            Route::delete('/{comment}', [CommentController::class, 'destroy']);
        });
    });
});
