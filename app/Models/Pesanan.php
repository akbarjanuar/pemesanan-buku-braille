<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'nomor_pesanan',
        'status',
        'alasan_pembatalan',
        'jenis_pesanan',
        'tanggal_pemesanan',
        'nama_penerima',
        'telepon',
        'alamat_lengkap',
        'provinsi',
        'kota',
        'kecamatan',
        'kode_pos',
        'catatan',
    ];

    public function details()
    {
        return $this->hasMany(PesananDetail::class, 'pesanan_id');
    }
}