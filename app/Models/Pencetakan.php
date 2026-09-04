<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencetakan extends Model
{
    use HasFactory;

    protected $table = 'pencetakans';

    // Cukup satu $fillable saja untuk mendefinisikan kolom yang boleh diisi
    protected $fillable = [
        'pesanan_id',
        'kode_cetak',
        'jenis_literasi',
        'pic',
        'target_buku',
        'buku_selesai',
        'deadline',
        'status',
    ];

    // Relasi ke tabel Pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}