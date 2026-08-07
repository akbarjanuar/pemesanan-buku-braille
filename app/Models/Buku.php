<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara manual
    protected $table = 'buku';

    protected $fillable = [
        'judul',
        'pengarang',
        'kategori',
        'stok',
        'warna_cover',
    ];
}