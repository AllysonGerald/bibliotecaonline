<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Configurações da Biblioteca
    |--------------------------------------------------------------------------
    |
    | Configurações relacionadas ao funcionamento da biblioteca online.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Taxa de Multa por Dia de Atraso
    |--------------------------------------------------------------------------
    |
    | Valor em reais (R$) cobrado por cada dia de atraso na devolução de um livro.
    |
    */
    'fine_per_day' => env('LIBRARY_FINE_PER_DAY', 5.00),

    /*
    |--------------------------------------------------------------------------
    | Prazo Padrão de Aluguel (em dias)
    |--------------------------------------------------------------------------
    |
    | Número de dias padrão para aluguel de livros.
    |
    */
    'default_rental_days' => env('LIBRARY_DEFAULT_RENTAL_DAYS', 14),
];
