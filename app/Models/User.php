<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang dapat diisi secara langsung.
     */
    protected $fillable = [
        'nama',
        'email',
        'nomor_telepon',
        'alamat',
        'kata_sandi',
        'foto_ktp',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    /**
     * Memberitahu Laravel bahwa nama kolom kata sandi adalah 'kata_sandi' bukan 'password'.
     */
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }
}