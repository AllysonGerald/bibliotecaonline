<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request de validação para envio de mensagem de contato.
 */
class ContactRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     *
     * @return bool Sempre retorna true (público)
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
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O email deve ser um endereço válido.',
            'email.max' => 'O email não pode ter mais de 255 caracteres.',
            'assunto.required' => 'O campo assunto é obrigatório.',
            'assunto.max' => 'O assunto não pode ter mais de 255 caracteres.',
            'mensagem.required' => 'O campo mensagem é obrigatório.',
            'mensagem.max' => 'A mensagem não pode ter mais de 5000 caracteres.',
        ];
    }

    /**
     * Retorna as regras de validação para a requisição.
     *
     * @return array<string, array<int, string>> Regras de validação
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'assunto' => ['required', 'string', 'max:255'],
            'mensagem' => ['required', 'string', 'max:5000'],
        ];
    }
}
