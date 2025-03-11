<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;

// Rota do feed de notícias (página inicial) – acesso público
Route::get('/', [PostController::class, 'index'])->name('home');

// Rotas de autenticação via Microsoft Entra ID
Route::get('/login/microsoft', [AuthController::class, 'redirectToProvider'])->name('login.microsoft');
Route::get('/login/microsoft/callback', [AuthController::class, 'handleProviderCallback']);

// Rota para logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas para criação de postagens (usuários autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});

// Rotas administrativas (acesso apenas para admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});