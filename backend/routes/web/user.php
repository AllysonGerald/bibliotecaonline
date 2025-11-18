<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function (): void {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/livros', [App\Http\Controllers\BookController::class, 'index'])->name('livros.index');
    Route::get('/livros/{livro}', [App\Http\Controllers\BookController::class, 'show'])->name('livros.show');

    Route::get('/meus-alugueis', function () {
        return view('user.alugueis');
    })->name('meus-alugueis');

    Route::get('/minhas-reservas', function () {
        return view('user.reservas');
    })->name('minhas-reservas');

    Route::get('/perfil', function () {
        return view('user.perfil');
    })->name('perfil');

    Route::get('/lista-desejos', function () {
        return view('user.wishlist');
    })->name('lista-desejos');

    Route::get('/contato', function () {
        return view('contato');
    })->name('contato');
});
