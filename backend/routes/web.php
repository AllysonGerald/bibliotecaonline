<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->group(function (): void {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/livros', function () {
        return view('livros.index');
    })->name('livros.index');

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

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/livros', function () {
        return view('admin.livros.index');
    })->name('livros.index');

    Route::get('/autores', function () {
        return view('admin.autores.index');
    })->name('autores.index');

    Route::get('/categorias', function () {
        return view('admin.categorias.index');
    })->name('categorias.index');

    Route::get('/alugueis', function () {
        return view('admin.alugueis.index');
    })->name('alugueis.index');

    Route::get('/reservas', function () {
        return view('admin.reservas.index');
    })->name('reservas.index');

    Route::get('/usuarios', function () {
        return view('admin.usuarios.index');
    })->name('usuarios.index');
});

require __DIR__.'/auth.php';
