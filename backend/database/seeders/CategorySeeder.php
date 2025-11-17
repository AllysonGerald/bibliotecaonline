<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nome' => 'Ficção',
                'descricao' => 'Obras de ficção literária, romances e narrativas imaginárias',
                'icone' => '📚',
            ],
            [
                'nome' => 'Romance',
                'descricao' => 'Histórias de amor e relacionamentos',
                'icone' => '💕',
            ],
            [
                'nome' => 'Suspense',
                'descricao' => 'Histórias de mistério e suspense',
                'icone' => '🔍',
            ],
            [
                'nome' => 'Fantasia',
                'descricao' => 'Mundos mágicos e criaturas fantásticas',
                'icone' => '🧙',
            ],
            [
                'nome' => 'Ficção Científica',
                'descricao' => 'Histórias baseadas em ciência e tecnologia',
                'icone' => '🚀',
            ],
            [
                'nome' => 'Terror',
                'descricao' => 'Histórias de horror e medo',
                'icone' => '👻',
            ],
            [
                'nome' => 'Biografia',
                'descricao' => 'Histórias de vida de pessoas reais',
                'icone' => '👤',
            ],
            [
                'nome' => 'Autoajuda',
                'descricao' => 'Desenvolvimento pessoal e motivacional',
                'icone' => '💪',
            ],
            [
                'nome' => 'História',
                'descricao' => 'Eventos e fatos históricos',
                'icone' => '📜',
            ],
            [
                'nome' => 'Tecnologia',
                'descricao' => 'Livros sobre tecnologia e programação',
                'icone' => '💻',
            ],
            [
                'nome' => 'Negócios',
                'descricao' => 'Empreendedorismo e gestão empresarial',
                'icone' => '💼',
            ],
            [
                'nome' => 'Infantil',
                'descricao' => 'Livros para crianças',
                'icone' => '🧸',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
