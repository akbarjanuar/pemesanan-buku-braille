<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencetakan extends Model
{
    use HasFactory;

    protected $table = 'pencetakans';

    // Tambahkan kolom baru ke dalam $fillable
    protected $fillable = [
        'pesanan_id',
        'buku_id',
        'kode_cetak',
        'jenis_literasi',
        'divisi',
        'jumlah',
        'catatan',
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

    // Tambahan relasi ke tabel Buku (opsional tapi sangat disarankan)
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}