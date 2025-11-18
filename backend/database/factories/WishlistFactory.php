<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class WishlistFactory extends Factory
{
    protected $model = Wishlist::class;

    public function definition(): array
    {
        return [
            'usuario_id' => User::factory(),
            'livro_id' => Book::factory(),
        ];
    }
}
