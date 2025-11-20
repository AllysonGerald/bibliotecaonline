<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
})->name('welcome');

Route::get('/contato', [App\Http\Controllers\ContactController::class, 'show'])->name('contato');
Route::post('/contato', [App\Http\Controllers\ContactController::class, 'store'])->name('contato.store');
