<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Model que representa um usuário no sistema.
 */
class User extends Authenticatable
{
    use HasApiTokens;

    use HasFactory;

    use Notifiable;

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'papel',
        'ativo',
        'telefone',
    ];

    /**
     * Atributos que devem ser ocultos na serialização.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Retorna a relação com as multas do usuário.
     *
     * @return HasMany Relação com multas
     */
    public function fines(): HasMany
    {
        return $this->hasMany(Fine::class, 'usuario_id');
    }

    /**
     * Verifica se o usuário está ativo.
     *
     * @return bool True se o usuário estiver ativo
     */
    public function isActive(): bool
    {
        return $this->ativo === true;
    }

    /**
     * Verifica se o usuário é administrador.
     *
     * @return bool True se o usuário for administrador
     */
    public function isAdmin(): bool
    {
        return $this->papel === UserRole::ADMIN;
    }

    /**
     * Retorna a relação com os aluguéis do usuário.
     *
     * @return HasMany Relação com aluguéis
     */
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class, 'usuario_id');
    }

    /**
     * Retorna a relação com as reservas do usuário.
     *
     * @return HasMany Relação com reservas
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'usuario_id');
    }

    /**
     * Retorna a relação com as avaliações do usuário.
     *
     * @return HasMany Relação com avaliações
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'usuario_id');
    }

    /**
     * Retorna a relação com a lista de desejos do usuário.
     *
     * @return HasMany Relação com lista de desejos
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'usuario_id');
    }

    /**
     * Retorna os atributos que devem ser convertidos para tipos nativos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'papel' => UserRole::class,
            'ativo' => 'boolean',
        ];
    }
}
