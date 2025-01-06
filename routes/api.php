<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogOutController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TasksShareController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);
Route::post('/logout', LogOutController::class)->middleware('auth:sanctum');

// Tasks
Route::apiResource('/tasks', TasksController::class)->middleware('auth:sanctum');

// Task Shares
Route::apiResource('/task_shares', TasksShareController::class)->middleware('auth:sanctum');
