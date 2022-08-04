<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{RoleController, UserController, BookController, MemberController, BooklocationController, BookloanController, ProfilController};
use App\Http\Controllers\Auth\LoginController;

// Login Routes ...
Route::get('/', [App\Http\Controllers\HomeController::class, 'listbook'])->name('home');
Route::get('login', [LoginController::class, 'showLoginForm']);
Route::post('login', [LoginController::class,'login'])->name('login');
Route::post('logout',  [LoginController::class,'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

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
    Route::post('members/import', [MemberController::class, 'import'])->name('members.import');
    Route::get('members/export', [MemberController::class, 'export'])->name('members.export');
    Route::get('members/printpdf', [MemberController::class, 'printPDF'])->name('members.printpdf');
    Route::resources(['members' => MemberController::class]);
    Route::post('members/delete-selected', [MemberController::class, 'deleteSelected'])->name('members.deleteSelected');

    // Lokasi Buku
    Route::resources(['booklocations' => BooklocationController::class]);
    Route::post('booklocations/delete-selected', [BooklocationController::class, 'deleteSelected'])->name('booklocations.deleteSelected');

    // Peminjaman Buku
    Route::resources(['bookloans' => BookloanController::class]);
    Route::post('bookloans/delete-selected', [BookloanController::class, 'deleteSelected'])->name('bookloans.deleteSelected');
    Route::post('bookloans/{bookloan}/proccess-loan', [BookloanController::class, 'processLoan'])->name('bookloans.processLoan');
    Route::post('bookloans/{bookloan}/print-pdf', [BookloanController::class, 'printPdf'])->name('bookloans.printPdf');

    // Roles
    Route::resources(['roles' => RoleController::class]);

    // Profil
    Route::get('profils', [ProfilController::class, 'index'])->name('profils.index');
    Route::post('profils', [ProfilController::class, 'store'])->name('profils.store');
    Route::get('profils/{profil}/edit', [ProfilController::class, 'edit'])->name('profils.edit');

    Route::prefix('trash')->group(function () {
        Route::get('books', [BookController::class, 'trash'])->name('books.trash');
        Route::get('books/restore/{id}', [BookController::class, 'restore'])->name('books.restore');
        Route::delete('books/delete/{id}', [BookController::class, 'deletePermanent'])->name('books.deletePermanent');
        Route::delete('books/deleteAll/', [BookController::class, 'deleteAll'])->name('books.deleteAll');

        Route::get('bookloans', [BookloanController::class, 'trash'])->name('bookloans.trash');
        Route::get('bookloans/restore/{id}', [BookloanController::class, 'restore'])->name('bookloans.restore');
        Route::delete('bookloans/delete/{id}', [BookloanController::class, 'deletePermanent'])->name('bookloans.deletePermanent');
        Route::delete('bookloans/deleteAll/', [BookloanController::class, 'deleteAll'])->name('bookloans.deleteAll');
    });
});
