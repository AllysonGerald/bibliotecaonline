<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request de validação para criação de aluguel pelo usuário.
 */
class StoreUserRentalRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     *
     * @return bool Sempre retorna true (requer autenticação via middleware)
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Retorna as mensagens de erro personalizadas para as regras de validação.
     *
     * @return array<string, string> Mensagens de erro (vazio pois não há validação)
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Retorna as regras de validação para a requisição.
     *
     * @return array<string, array<int, string>> Regras de validação (vazio pois não há validação)
     */
    public function rules(): array
    {
        return [];
    }
}
