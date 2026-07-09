<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'status', 'avatar', 'phone'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'integer',
            'status' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 0;
    }

    public function isSeller(): bool
    {
        return $this->role === 1;
    }

    public function isBuyer(): bool
    {
        return $this->role === 2;
    }

    public function sellerDetail()
    {
        return $this->hasOne(SellerDetail::class);
    }

    public function buyerDetail()
    {
        return $this->hasOne(BuyerDetail::class, 'user_id');
    }
}
