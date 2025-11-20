<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request de validação para criação de avaliação de livro.
 */
class StoreReviewRequest extends FormRequest
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
     * @return array<string, string> Mensagens de erro
     */
    public function messages(): array
    {
        return [
            'nota.required' => 'A nota é obrigatória.',
            'nota.integer' => 'A nota deve ser um número inteiro.',
            'nota.min' => 'A nota mínima é 1.',
            'nota.max' => 'A nota máxima é 5.',
            'comentario.max' => 'O comentário não pode ter mais de 2000 caracteres.',
        ];
    }

    /**
     * Retorna as regras de validação para a requisição.
     *
     * @return array<string, array<int, string>> Regras de validação
     */
    public function rules(): array
    {
        $user = $this->user();
        $bookId = $this->route('livro')->id;

        return [
            'nota' => ['required', 'integer', 'min:1', 'max:5'],
            'comentario' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * Prepara os dados para validação.
     * Converte string vazia em null no campo comentário.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('comentario') && $this->comentario === '') {
            $this->merge([
                'comentario' => null,
            ]);
        }
    }
}
