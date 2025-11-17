<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Rotas de Livros
    Route::resource('livros', App\Http\Controllers\Admin\BookController::class)->names([
        'index' => 'livros.index',
        'create' => 'livros.create',
        'store' => 'livros.store',
        'show' => 'livros.show',
        'edit' => 'livros.edit',
        'update' => 'livros.update',
        'destroy' => 'livros.destroy',
    ]);

    // Rotas de Autores
    Route::resource('autores', App\Http\Controllers\Admin\AuthorController::class)
        ->parameters(['autores' => 'autor'])
        ->names([
            'index' => 'autores.index',
            'create' => 'autores.create',
            'store' => 'autores.store',
            'show' => 'autores.show',
            'edit' => 'autores.edit',
            'update' => 'autores.update',
            'destroy' => 'autores.destroy',
        ])
    ;

    // Rotas de Categorias
    Route::resource('categorias', App\Http\Controllers\Admin\CategoryController::class)->names([
        'index' => 'categorias.index',
        'create' => 'categorias.create',
        'store' => 'categorias.store',
        'show' => 'categorias.show',
        'edit' => 'categorias.edit',
        'update' => 'categorias.update',
        'destroy' => 'categorias.destroy',
    ]);

    // Rotas futuras (alugueis, reservas, usuarios)
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
