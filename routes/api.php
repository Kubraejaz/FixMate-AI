<?php

use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/get/user', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show'])->name('user.show');
Route::get('users/login', [UserController::class, 'login'])->name('user.login');