<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama tabel di Supabase kamu
    protected $table = 'buku';

    protected $fillable = [
        'judul',
        'pengarang',
        'kategori',
        'deskripsi',
        'stok',
        'warna_cover',
        'penerbit',
        'batas_pemesanan',
        'isbn',
        'tahun_terbit',
    ];
}