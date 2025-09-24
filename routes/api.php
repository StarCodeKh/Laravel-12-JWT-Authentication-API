<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
});

Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class,'index']); // List users
    Route::post('/users', [UserController::class,'store']); // Create user
    Route::get('/users/{id}', [UserController::class,'show']); // Show user
    Route::put('/users/{id}', [UserController::class,'update']); // Update user
    Route::delete('/users/{id}', [UserController::class,'destroy']); // Delete user
});

Route::middleware('auth:api')->group(function () {
    // Roles
    Route::apiResource('roles', RoleController::class)->except(['create', 'edit']);

    // Permissions
    Route::get('/permissions', [PermissionController::class, 'index']);
    Route::post('/permissions', [PermissionController::class, 'store']);
});
