<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\BookStatus;
use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            // Machado de Assis
            [
                'titulo' => 'Dom Casmurro',
                'descricao' => 'Romance de Machado de Assis que narra a história de Bentinho e Capitu, um dos casais mais famosos da literatura brasileira.',
                'autor_id' => 1,
                'categoria_id' => 1,
                'isbn' => '9788544001059',
                'editora' => 'Penguin Companhia',
                'ano_publicacao' => 1899,
                'paginas' => 256,
                'preco' => 32.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 5,
            ],
            [
                'titulo' => 'Memórias Póstumas de Brás Cubas',
                'descricao' => 'Obra-prima de Machado de Assis, narrada por um defunto autor que conta sua vida de forma irônica e reflexiva.',
                'autor_id' => 1,
                'categoria_id' => 1,
                'isbn' => '9788544001066',
                'editora' => 'Penguin Companhia',
                'ano_publicacao' => 1881,
                'paginas' => 368,
                'preco' => 34.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 3,
            ],
            // Paulo Coelho
            [
                'titulo' => 'O Alquimista',
                'descricao' => 'História de Santiago, um jovem pastor que busca seu tesouro e descobre lições sobre a vida e o destino.',
                'autor_id' => 2,
                'categoria_id' => 1,
                'isbn' => '9788595080621',
                'editora' => 'Planeta',
                'ano_publicacao' => 1988,
                'paginas' => 208,
                'preco' => 29.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 8,
            ],
            [
                'titulo' => 'Brida',
                'descricao' => 'Romance sobre uma jovem irlandesa em busca de conhecimento sobre magia e sua busca espiritual.',
                'autor_id' => 2,
                'categoria_id' => 1,
                'isbn' => '9788595081659',
                'editora' => 'Planeta',
                'ano_publicacao' => 1990,
                'paginas' => 208,
                'preco' => 27.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 4,
            ],
            // Clarice Lispector
            [
                'titulo' => 'A Hora da Estrela',
                'descricao' => 'Última obra de Clarice Lispector, conta a história de Macabéa, uma jovem nordestina no Rio de Janeiro.',
                'autor_id' => 3,
                'categoria_id' => 1,
                'isbn' => '9788520938690',
                'editora' => 'Rocco',
                'ano_publicacao' => 1977,
                'paginas' => 88,
                'preco' => 24.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 6,
            ],
            // Jorge Amado
            [
                'titulo' => 'Capitães da Areia',
                'descricao' => 'Romance sobre um grupo de meninos de rua em Salvador, Bahia.',
                'autor_id' => 4,
                'categoria_id' => 1,
                'isbn' => '9788535911664',
                'editora' => 'Companhia das Letras',
                'ano_publicacao' => 1937,
                'paginas' => 280,
                'preco' => 45.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 4,
            ],
            [
                'titulo' => 'Dona Flor e Seus Dois Maridos',
                'descricao' => 'História de Dona Flor, viúva que se casa novamente, mas é assombrada pelo primeiro marido.',
                'autor_id' => 4,
                'categoria_id' => 2,
                'isbn' => '9788535914265',
                'editora' => 'Companhia das Letras',
                'ano_publicacao' => 1966,
                'paginas' => 432,
                'preco' => 54.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 3,
            ],
            // Monteiro Lobato
            [
                'titulo' => 'O Sítio do Picapau Amarelo',
                'descricao' => 'Clássico da literatura infantil brasileira com as aventuras de Narizinho, Pedrinho e Emília.',
                'autor_id' => 8,
                'categoria_id' => 12,
                'isbn' => '9788525061447',
                'editora' => 'Globo Livros',
                'ano_publicacao' => 1920,
                'paginas' => 144,
                'preco' => 29.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 10,
            ],
            // J.K. Rowling
            [
                'titulo' => 'Harry Potter e a Pedra Filosofal',
                'descricao' => 'Primeiro livro da saga Harry Potter, sobre um jovem bruxo que descobre seu destino mágico.',
                'autor_id' => 11,
                'categoria_id' => 4,
                'isbn' => '9788532530787',
                'editora' => 'Rocco',
                'ano_publicacao' => 1997,
                'paginas' => 264,
                'preco' => 39.90,
                'status' => BookStatus::ALUGADO->value,
                'quantidade' => 7,
            ],
            [
                'titulo' => 'Harry Potter e a Câmara Secreta',
                'descricao' => 'Segundo livro da saga, Harry retorna a Hogwarts e enfrenta novos mistérios.',
                'autor_id' => 11,
                'categoria_id' => 4,
                'isbn' => '9788532530794',
                'editora' => 'Rocco',
                'ano_publicacao' => 1998,
                'paginas' => 288,
                'preco' => 39.90,
                'status' => BookStatus::RESERVADO->value,
                'quantidade' => 6,
            ],
            // George Orwell
            [
                'titulo' => '1984',
                'descricao' => 'Distopia sobre um futuro totalitário onde o governo controla todos os aspectos da vida.',
                'autor_id' => 12,
                'categoria_id' => 5,
                'isbn' => '9788535914849',
                'editora' => 'Companhia das Letras',
                'ano_publicacao' => 1949,
                'paginas' => 416,
                'preco' => 49.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 5,
            ],
            [
                'titulo' => 'A Revolução dos Bichos',
                'descricao' => 'Fábula política sobre animais que se rebelam contra seus donos humanos.',
                'autor_id' => 12,
                'categoria_id' => 1,
                'isbn' => '9788535914078',
                'editora' => 'Companhia das Letras',
                'ano_publicacao' => 1945,
                'paginas' => 152,
                'preco' => 37.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 4,
            ],
            // Agatha Christie
            [
                'titulo' => 'Assassinato no Expresso do Oriente',
                'descricao' => 'Mistério clássico onde Hercule Poirot investiga um assassinato em um trem de luxo.',
                'autor_id' => 13,
                'categoria_id' => 3,
                'isbn' => '9788595086166',
                'editora' => 'HarperCollins',
                'ano_publicacao' => 1934,
                'paginas' => 256,
                'preco' => 42.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 4,
            ],
            [
                'titulo' => 'Morte no Nilo',
                'descricao' => 'Hercule Poirot investiga um assassinato durante um cruzeiro no rio Nilo.',
                'autor_id' => 13,
                'categoria_id' => 3,
                'isbn' => '9788595086197',
                'editora' => 'HarperCollins',
                'ano_publicacao' => 1937,
                'paginas' => 352,
                'preco' => 44.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 3,
            ],
            // Stephen King
            [
                'titulo' => 'O Iluminado',
                'descricao' => 'História de terror sobre uma família isolada em um hotel assombrado durante o inverno.',
                'autor_id' => 14,
                'categoria_id' => 6,
                'isbn' => '9788581050287',
                'editora' => 'Suma',
                'ano_publicacao' => 1977,
                'paginas' => 464,
                'preco' => 52.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 5,
            ],
            [
                'titulo' => 'It - A Coisa',
                'descricao' => 'Terror sobre uma entidade malígna que aterroriza crianças em uma pequena cidade.',
                'autor_id' => 14,
                'categoria_id' => 6,
                'isbn' => '9788581050294',
                'editora' => 'Suma',
                'ano_publicacao' => 1986,
                'paginas' => 1104,
                'preco' => 69.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 6,
            ],
            // Isaac Asimov
            [
                'titulo' => 'Eu, Robô',
                'descricao' => 'Coletânea de contos sobre robôs e as Três Leis da Robótica.',
                'autor_id' => 15,
                'categoria_id' => 5,
                'isbn' => '9788576570547',
                'editora' => 'Aleph',
                'ano_publicacao' => 1950,
                'paginas' => 320,
                'preco' => 47.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 4,
            ],
            [
                'titulo' => 'Fundação',
                'descricao' => 'Primeiro livro da trilogia que narra a queda de um império galáctico.',
                'autor_id' => 15,
                'categoria_id' => 5,
                'isbn' => '9788576570554',
                'editora' => 'Aleph',
                'ano_publicacao' => 1951,
                'paginas' => 296,
                'preco' => 49.90,
                'status' => BookStatus::DISPONIVEL->value,
                'quantidade' => 3,
            ],
        ];

        foreach ($books as $bookData) {
            $book = Book::create($bookData);

            // Adicionar tags aleatórias
            $book->tags()->attach([1, 9]); // Clássico e Brasileiro para livros nacionais
        }
    }
}
