<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(static function (): void {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

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

    // Rotas de Aluguéis
    Route::resource('alugueis', App\Http\Controllers\Admin\RentalController::class)
        ->parameters(['alugueis' => 'aluguel'])
        ->names([
            'index' => 'alugueis.index',
            'create' => 'alugueis.create',
            'store' => 'alugueis.store',
            'show' => 'alugueis.show',
            'edit' => 'alugueis.edit',
            'update' => 'alugueis.update',
            'destroy' => 'alugueis.destroy',
        ])
    ;

    // Rotas de Reservas
    Route::resource('reservas', App\Http\Controllers\Admin\ReservationController::class)
        ->parameters(['reservas' => 'reserva'])
        ->names([
            'index' => 'reservas.index',
            'create' => 'reservas.create',
            'store' => 'reservas.store',
            'show' => 'reservas.show',
            'edit' => 'reservas.edit',
            'update' => 'reservas.update',
            'destroy' => 'reservas.destroy',
        ])
    ;

    // Rotas de Usuários
    Route::resource('usuarios', App\Http\Controllers\Admin\UserController::class)
        ->parameters(['usuarios' => 'usuario'])
        ->names([
            'index' => 'usuarios.index',
            'create' => 'usuarios.create',
            'store' => 'usuarios.store',
            'show' => 'usuarios.show',
            'edit' => 'usuarios.edit',
            'update' => 'usuarios.update',
            'destroy' => 'usuarios.destroy',
        ])
    ;

    // Rotas de Contatos
    Route::resource('contatos', App\Http\Controllers\Admin\ContactController::class)
        ->parameters(['contatos' => 'contato'])
        ->names([
            'index' => 'contatos.index',
            'show' => 'contatos.show',
            'destroy' => 'contatos.destroy',
        ])
    ;
    Route::post('contatos/{contato}/mark-as-read', [App\Http\Controllers\Admin\ContactController::class, 'markAsRead'])
        ->name('contatos.mark-as-read')
    ;

    // Rotas de Atividades
    Route::get('atividades', [App\Http\Controllers\Admin\ActivityController::class, 'index'])
        ->name('atividades.index')
    ;

    // Rotas de Multas
    // Rotas específicas devem vir ANTES da rota resource para evitar conflitos
    Route::get('multas/solicitacoes-pagamento', [App\Http\Controllers\Admin\FineController::class, 'paymentRequests'])
        ->name('multas.payment-requests')
    ;
    Route::post('multas/{multa}/pagar', [App\Http\Controllers\Admin\FineController::class, 'pay'])
        ->name('multas.pay')
    ;
    Route::resource('multas', App\Http\Controllers\Admin\FineController::class)
        ->parameters(['multas' => 'multa'])
        ->only(['index', 'show'])
        ->names([
            'index' => 'multas.index',
            'show' => 'multas.show',
        ])
    ;
});
