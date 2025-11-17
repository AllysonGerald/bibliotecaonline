<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            [
                'nome' => 'Machado de Assis',
                'biografia' => 'Joaquim Maria Machado de Assis foi um escritor brasileiro, considerado por muitos críticos o maior nome da literatura brasileira.',
                'data_nascimento' => '1839-06-21',
            ],
            [
                'nome' => 'Paulo Coelho',
                'biografia' => 'Paulo Coelho é um romancista e poeta brasileiro, um dos escritores mais vendidos do mundo.',
                'data_nascimento' => '1947-08-24',
            ],
            [
                'nome' => 'Clarice Lispector',
                'biografia' => 'Clarice Lispector foi uma escritora e jornalista nascida na Ucrânia e naturalizada brasileira.',
                'data_nascimento' => '1920-12-10',
            ],
            [
                'nome' => 'Jorge Amado',
                'biografia' => 'Jorge Amado foi um dos mais famosos e traduzidos escritores brasileiros de todos os tempos.',
                'data_nascimento' => '1912-08-10',
            ],
            [
                'nome' => 'Cecília Meireles',
                'biografia' => 'Cecília Meireles foi uma poetisa, pintora, professora e jornalista brasileira.',
                'data_nascimento' => '1901-11-07',
            ],
            [
                'nome' => 'Carlos Drummond de Andrade',
                'biografia' => 'Carlos Drummond de Andrade foi um poeta, contista e cronista brasileiro, considerado um dos maiores poetas brasileiros.',
                'data_nascimento' => '1902-10-31',
            ],
            [
                'nome' => 'Érico Veríssimo',
                'biografia' => 'Érico Veríssimo foi um escritor brasileiro, autor de romances como O Tempo e o Vento.',
                'data_nascimento' => '1905-12-17',
            ],
            [
                'nome' => 'Monteiro Lobato',
                'biografia' => 'José Bento Renato Monteiro Lobato foi um dos mais influentes escritores brasileiros do século XX.',
                'data_nascimento' => '1882-04-18',
            ],
            [
                'nome' => 'Fernando Pessoa',
                'biografia' => 'Fernando Pessoa foi um poeta, filósofo e escritor português, considerado um dos maiores poetas da língua portuguesa.',
                'data_nascimento' => '1888-06-13',
            ],
            [
                'nome' => 'Graciliano Ramos',
                'biografia' => 'Graciliano Ramos foi um romancista, cronista, contista, jornalista e político brasileiro.',
                'data_nascimento' => '1892-10-27',
            ],
            [
                'nome' => 'J.K. Rowling',
                'biografia' => 'Joanne Rowling é uma escritora britânica, autora da série Harry Potter.',
                'data_nascimento' => '1965-07-31',
            ],
            [
                'nome' => 'George Orwell',
                'biografia' => 'Eric Arthur Blair, mais conhecido por seu pseudônimo George Orwell, foi um escritor e jornalista inglês.',
                'data_nascimento' => '1903-06-25',
            ],
            [
                'nome' => 'Agatha Christie',
                'biografia' => 'Agatha Christie foi uma escritora britânica que atuou como romancista e dramaturga.',
                'data_nascimento' => '1890-09-15',
            ],
            [
                'nome' => 'Stephen King',
                'biografia' => 'Stephen King é um escritor norte-americano, reconhecido como um dos mais notáveis escritores de contos de horror.',
                'data_nascimento' => '1947-09-21',
            ],
            [
                'nome' => 'Isaac Asimov',
                'biografia' => 'Isaac Asimov foi um escritor e bioquímico americano, autor de ficção científica e divulgação científica.',
                'data_nascimento' => '1920-01-02',
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
