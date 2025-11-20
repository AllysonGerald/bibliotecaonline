<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\RegisterUserDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

/**
 * Service responsável pela lógica de negócio relacionada a autenticação.
 */
class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * Tenta autenticar um usuário no sistema.
     *
     * @param string $email Email do usuário
     * @param string $password Senha do usuário
     * @param bool $remember Se deve lembrar do usuário
     * @return bool True se autenticado com sucesso
     */
    public function attemptLogin(string $email, string $password, bool $remember = false): bool
    {
        return auth()->attempt([
            'email' => $email,
            'password' => $password,
        ], $remember);
    }

    /**
     * Realiza logout do usuário autenticado.
     */
    public function logout(): void
    {
        auth()->logout();
    }

    /**
     * Registra um novo usuário no sistema.
     * A senha é criptografada pelo UserRepository.
     *
     * @param RegisterUserDTO $dto Dados do usuário a ser registrado
     * @return User Usuário criado
     */
    public function register(RegisterUserDTO $dto): User
    {
        $data = $dto->toArray();
        $data['password'] = Hash::make($dto->password);

        return $this->userRepository->create($data);
    }
}
