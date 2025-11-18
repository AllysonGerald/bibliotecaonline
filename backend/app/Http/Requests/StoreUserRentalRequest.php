<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRentalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'livro_id' => ['required', 'integer', 'exists:livros,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'livro_id.required' => 'O livro é obrigatório.',
            'livro_id.integer' => 'O livro deve ser um número inteiro.',
            'livro_id.exists' => 'O livro selecionado não existe.',
        ];
    }
}
