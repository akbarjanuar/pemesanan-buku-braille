<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanBahan extends Model
{
    use HasFactory;

    protected $table = 'permintaan_bahans';

    protected $fillable = [
        'id_permintaan',
        'pencetakan_id',
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

    // Relasi ke model Pencetakan
    public function pencetakan()
    {
        return $this->belongsTo(Pencetakan::class, 'pencetakan_id');
    }

    // Relasi langsung ke model Buku (jika ada)
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_permintaan)) {
                $tahun = date('Y');
                
                $lastRecord = self::whereYear('created_at', $tahun)
                                    ->orderBy('id', 'desc')
                                    ->first();

                $nextId = $lastRecord ? ($lastRecord->id + 1) : 1;
                
                $model->id_permintaan = 'BHN-' . $tahun . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}