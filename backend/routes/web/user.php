<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function (): void {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/livros', [App\Http\Controllers\BookController::class, 'index'])->name('livros.index');
    Route::get('/livros/{livro}', [App\Http\Controllers\BookController::class, 'show'])->name('livros.show');

    Route::get('/meus-alugueis', [App\Http\Controllers\UserRentalController::class, 'index'])->name('meus-alugueis');

    Route::get('/minhas-reservas', [App\Http\Controllers\UserReservationController::class, 'index'])->name('minhas-reservas');

    Route::get('/perfil', [App\Http\Controllers\ProfileController::class, 'show'])->name('perfil');
    Route::put('/perfil', [App\Http\Controllers\ProfileController::class, 'update'])->name('perfil.update');

    Route::get('/lista-desejos', function () {
        return view('user.wishlist');
    })->name('lista-desejos');

    Route::get('/contato', function () {
        return view('contato');
    })->name('contato');
});
