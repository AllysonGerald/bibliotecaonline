<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Clássico',
            'Best Seller',
            'Lançamento',
            'Aventura',
            'Comédia',
            'Drama',
            'Mistério',
            'Policial',
            'Brasileiro',
            'Internacional',
            'Juvenil',
            'Adulto',
            'Educativo',
            'Inspirador',
            'Reflexivo',
        ];

        foreach ($tags as $tag) {
            Tag::create(['nome' => $tag]);
        }
    }
}
