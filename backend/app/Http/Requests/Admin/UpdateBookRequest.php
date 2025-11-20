<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\BookStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * Request de validação para atualização de livro.
 */
class UpdateBookRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     *
     * @return bool True se o usuário for administrador
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Retorna as mensagens de erro personalizadas para as regras de validação.
     *
     * @return array<string, string> Mensagens de erro
     */
    public function messages(): array
    {
        return [
            'titulo.required' => 'O campo título é obrigatório.',
            'descricao.required' => 'O campo descrição é obrigatório.',
            'autor_id.required' => 'O campo autor é obrigatório.',
            'autor_id.exists' => 'O autor selecionado não existe.',
            'categoria_id.required' => 'O campo categoria é obrigatório.',
            'categoria_id.exists' => 'A categoria selecionada não existe.',
            'isbn.required' => 'O campo ISBN é obrigatório.',
            'isbn.unique' => 'Este ISBN já está cadastrado.',
            'editora.required' => 'O campo editora é obrigatório.',
            'ano_publicacao.required' => 'O campo ano de publicação é obrigatório.',
            'ano_publicacao.min' => 'O ano de publicação deve ser maior que 1000.',
            'ano_publicacao.max' => 'O ano de publicação não pode ser maior que o ano atual.',
            'paginas.required' => 'O campo páginas é obrigatório.',
            'paginas.min' => 'O livro deve ter pelo menos 1 página.',
            'preco.required' => 'O campo preço é obrigatório.',
            'preco.min' => 'O preço não pode ser negativo.',
            'imagem_capa.image' => 'O arquivo deve ser uma imagem.',
            'imagem_capa.max' => 'A imagem não pode ter mais de 2MB.',
            'status.required' => 'O campo status é obrigatório.',
            'quantidade.required' => 'O campo quantidade é obrigatório.',
            'quantidade.min' => 'A quantidade não pode ser negativa.',
        ];
    }

    /**
     * Retorna as regras de validação para a requisição.
     *
     * @return array<string, array<int, string>> Regras de validação
     */
    public function rules(): array
    {
        $bookId = $this->route('livro');
        $bookId = $bookId instanceof \App\Models\Book ? $bookId->id : $bookId;

        return [
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string'],
            'autor_id' => ['required', 'integer', 'exists:autores,id'],
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'isbn' => ['required', 'string', 'max:20', 'unique:livros,isbn,'.$bookId],
            'editora' => ['required', 'string', 'max:255'],
            'ano_publicacao' => ['required', 'integer', 'min:1000', 'max:'.date('Y')],
            'paginas' => ['required', 'integer', 'min:1'],
            'preco' => ['required', 'numeric', 'min:0'],
            'imagem_capa' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'status' => ['required', new Enum(BookStatus::class)],
            'quantidade' => ['required', 'integer', 'min:0'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
        ];
    }
}
