<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ================= ROLE HELPERS =================
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isRedaksi(): bool
    {
        return $this->role === 'redaksi';
    }

    public function isPenulis(): bool
    {
        return $this->role === 'penulis';
    }

    public function isPembaca(): bool
    {
        return $this->role === 'pembaca';
    }

    // ================= RELASI (dipakai nanti) =================
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function libraries()
    {
        return $this->hasMany(Library::class);
    }
}