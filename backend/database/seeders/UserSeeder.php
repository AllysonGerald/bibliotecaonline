<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin padrão
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@biblioteca.com',
            'password' => Hash::make('admin123'),
            'papel' => UserRole::ADMIN->value,
            'ativo' => true,
            'telefone' => '(11) 98765-4321',
            'email_verified_at' => now(),
        ]);

        // Usuários de teste
        User::create([
            'name' => 'João Silva',
            'email' => 'joao@email.com',
            'password' => Hash::make('senha123'),
            'papel' => UserRole::USUARIO->value,
            'ativo' => true,
            'telefone' => '(11) 91234-5678',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Maria Santos',
            'email' => 'maria@email.com',
            'password' => Hash::make('senha123'),
            'papel' => UserRole::USUARIO->value,
            'ativo' => true,
            'telefone' => '(11) 92345-6789',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Pedro Oliveira',
            'email' => 'pedro@email.com',
            'password' => Hash::make('senha123'),
            'papel' => UserRole::USUARIO->value,
            'ativo' => true,
            'telefone' => '(11) 93456-7890',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ana Costa',
            'email' => 'ana@email.com',
            'password' => Hash::make('senha123'),
            'papel' => UserRole::USUARIO->value,
            'ativo' => false,
            'telefone' => '(11) 94567-8901',
            'email_verified_at' => now(),
        ]);
    }
}
