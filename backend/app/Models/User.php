<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    use HasFactory;

    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'papel',
        'ativo',
        'telefone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function fines(): HasMany
    {
        return $this->hasMany(Fine::class, 'usuario_id');
    }

    public function isActive(): bool
    {
        return $this->ativo === true;
    }

    public function isAdmin(): bool
    {
        return $this->papel === UserRole::ADMIN;
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class, 'usuario_id');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'usuario_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'usuario_id');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'usuario_id');
    }

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
