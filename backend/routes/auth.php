<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

// Rotas de autenticação serão adicionadas na próxima branch
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/logout', function (): void {
    abort(404);
})->name('logout');
