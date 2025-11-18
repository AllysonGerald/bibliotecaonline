<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->user();
        $bookId = $this->route('livro')->id;

        return [
            'nota' => ['required', 'integer', 'min:1', 'max:5'],
            'comentario' => ['nullable', 'string', 'max:2000'],
        ];
    }

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

    protected function prepareForValidation(): void
    {
        // Converter string vazia para null no comentário
        if ($this->has('comentario') && $this->comentario === '') {
            $this->merge([
                'comentario' => null,
            ]);
        }
    }
}
