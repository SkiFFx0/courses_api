<?php

use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckStudentRole;
use App\Http\Middleware\CheckTeacherRole;
use App\Models\ApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Middleware\PermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware)
    {
        $middleware->alias([
            'role.admin' => CheckAdminRole::class,
            'role.teacher' => CheckTeacherRole::class,
            'role.student' => CheckStudentRole::class,
            'permission' => PermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions)
    {
        $exceptions->render(function (Exception $e)
        {
            if (get_class($e) === ValidationException::class)
            {
                return ApiResponse::error('Input data is not correct', null, 422);
            }
        });
    })->create();
