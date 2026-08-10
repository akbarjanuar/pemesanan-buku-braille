<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    
    protected $fillable = [
        'user_id',
        'buku_id',
        'jumlah',
    ];

    // Relasi untuk mengambil data buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}