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
    Route::post('/livros/{livro}/alugueis', [App\Http\Controllers\UserRentalController::class, 'store'])->name('alugueis.store');

    Route::get('/minhas-reservas', [App\Http\Controllers\UserReservationController::class, 'index'])->name('minhas-reservas');
    Route::post('/livros/{livro}/reservas', [App\Http\Controllers\UserReservationController::class, 'store'])->name('reservas.store');

    Route::get('/minhas-multas', [App\Http\Controllers\FineController::class, 'index'])->name('minhas-multas');

    Route::get('/perfil', [App\Http\Controllers\ProfileController::class, 'show'])->name('perfil');
    Route::put('/perfil', [App\Http\Controllers\ProfileController::class, 'update'])->name('perfil.update');

    Route::get('/lista-desejos', [App\Http\Controllers\WishlistController::class, 'index'])->name('lista-desejos');
    Route::post('/lista-desejos/{livro}', [App\Http\Controllers\WishlistController::class, 'store'])->name('lista-desejos.store');
    Route::delete('/lista-desejos/{wishlist}', [App\Http\Controllers\WishlistController::class, 'destroy'])->name('lista-desejos.destroy');

    // Rotas de Avaliações
    Route::post('/livros/{livro}/avaliacoes', [App\Http\Controllers\ReviewController::class, 'store'])->name('avaliacoes.store');
    Route::put('/avaliacoes/{review}', [App\Http\Controllers\ReviewController::class, 'update'])->name('avaliacoes.update');
    Route::delete('/avaliacoes/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('avaliacoes.destroy');
});
