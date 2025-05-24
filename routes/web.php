<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PosterController;
use App\Http\Controllers\AdminSessionController;
use App\Http\Controllers\AdminMovieController;
use App\Http\Controllers\MovieSessionController;
use App\Http\Controllers\MovieController;

Route::get('/', [PosterController::class, 'index'])->name('main');
Route::post('/buy/{session}', [PosterController::class, 'buy'])->middleware('auth')->name('buy');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route to personal cabinet, only for authenticated users
Route::get('/cabinet', [AuthController::class, 'showCabinet'])->middleware('auth')->name('cabinet');

Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Routes for admin session and movie creation
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/sessions/create', [AdminSessionController::class, 'create'])->name('admin.sessions.create');
    Route::post('/admin/sessions', [AdminSessionController::class, 'store'])->name('admin.sessions.store');

    // Routes for movie sessions
    Route::get('/sessions/create', [MovieSessionController::class, 'create'])->name('sessions.create');
    Route::post('/sessions', [MovieSessionController::class, 'store'])->name('sessions.store');
});

// Admin routes for movie CRUD operations
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('movies', AdminMovieController::class);
});
