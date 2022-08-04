<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{RoleController, UserController, BookController, MemberController, BooklocationController, BookloanController};
use App\Http\Controllers\Auth\LoginController;

// Login Routes ...
Route::get('', [LoginController::class, 'showLoginForm']);
Route::post('login', [LoginController::class,'login'])->name('login');
Route::post('logout',  [LoginController::class,'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Pengguna
    Route::resources(['users' => UserController::class]);
    Route::post('users/{user:id}/status', [UserController::class, 'changeStatus'])->name('users.status');
    // Buku
    Route::post('books/import', [BookController::class, 'import'])->name('books.import');
    Route::get('books/export', [BookController::class, 'export'])->name('books.export');
    Route::get('books/printpdf', [BookController::class, 'printPDF'])->name('books.printpdf');
    Route::resources(['books' => BookController::class]);
    Route::post('books/delete-selected', [BookController::class, 'deleteSelected'])->name('books.deleteSelected');

    // Anggota
    Route::resources(['members' => MemberController::class]);
    Route::post('members/delete-selected', [MemberController::class, 'deleteSelected'])->name('members.deleteSelected');
    // Lokasi Buku
    Route::resources(['booklocations' => BooklocationController::class]);
    Route::post('booklocations/delete-selected', [BooklocationController::class, 'deleteSelected'])->name('booklocations.deleteSelected');
    // Peminjaman Buku
    Route::resources(['bookloans' => BookloanController::class]);
    // Roles
    Route::resources(['roles' => RoleController::class]);
});
