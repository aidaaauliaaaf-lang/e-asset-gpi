<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi melalui mass assignment.
     */
    protected $fillable = [
        'name',
        'user',
        'username',
        'password',
        'role',
        'nik',
        'jabatan',
        'divisi',
        'no_telepon',
        'foto',
    ];

    /**
     * Kolom yang tidak ditampilkan dalam serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konversi tipe data atribut.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
