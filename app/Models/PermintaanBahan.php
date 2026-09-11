<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanBahan extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional tapi disarankan agar aman)
    protected $table = 'permintaan_bahans';

    // Kolom-kolom yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'id_permintaan',
        'divisi',
        'nama_bahan',
        'jumlah',
        'satuan',
        'keperluan',
        'status',
        'pengaju',
        'prioritas',
        'catatan_kendala'
    ];

    // Logika untuk membuat custom ID (BHN-Tahun-Urutan) otomatis saat data dibuat
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_permintaan)) {
                $tahun = date('Y');
                
                // Cari data terakhir di tahun yang sama
                $lastRecord = self::whereYear('created_at', $tahun)
                                  ->orderBy('id', 'desc')
                                  ->first();

                // Tentukan nomor urut berikutnya
                $nextId = $lastRecord ? ($lastRecord->id + 1) : 1;
                
                // Format menjadi BHN-2026-0001
                $model->id_permintaan = 'BHN-' . $tahun . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}