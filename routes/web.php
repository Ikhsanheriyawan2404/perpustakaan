<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Login Routes ...
Route::get('', [LoginController::class, 'showLoginForm']);
Route::post('login', [LoginController::class,'login'])->name('login');
Route::post('logout',  [LoginController::class,'logout'])->name('logout');

// Registration Routes...
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [RegisterController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resources(['users' => UserController::class]);
    Route::post('users/{user:id}/status', [UserController::class, 'changeStatus'])->name('users.status');
    Route::resources(['items' => ItemController::class]);
    Route::post('items/delete-selected', [ItemController::class, 'deleteSelected'])->name('items.deleteSelected');

    Route::resources(['categories' => CategoryController::class]);
    Route::post('categories/delete-selected', [CategoryController::class, 'deleteSelected'])->name('categories.deleteSelected');

    Route::resources(['accounts' => AccountController::class]);
    Route::post('accounts/delete-selected', [AccountController::class, 'deleteSelected'])->name('accounts.deleteSelected');

    Route::resources(['roles' => RoleController::class]);
});
