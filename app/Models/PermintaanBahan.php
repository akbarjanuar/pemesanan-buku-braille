<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
        'file_surat',
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

        // Global Scope: Otomatis memfilter data berdasarkan divisi URL yang diakses
        static::addGlobalScope('divisi_filter', function (Builder $builder) {
            if (!app()->runningInConsole() && auth()->check()) {
                if (request()->is('admin/manual*')) {
                    $builder->where('divisi', 'Literasi Manual');
                } elseif (request()->is('admin/digital*')) {
                    $builder->where('divisi', 'Literasi Digital');
                }
            }
        });

        static::creating(function ($model) {
            // Otomatis mengisi kolom divisi jika kosong saat data baru dibuat
            if (empty($model->divisi)) {
                if (request()->is('admin/manual*')) {
                    $model->divisi = 'Literasi Manual';
                } elseif (request()->is('admin/digital*')) {
                    $model->divisi = 'Literasi Digital';
                }
            }

            if (empty($model->id_permintaan)) {
                $tahun = date('Y');
                
                // Gunakan withoutGlobalScopes agar penomoran ID tetap akurat secara global
                $lastRecord = self::withoutGlobalScopes()
                                    ->whereYear('created_at', $tahun)
                                    ->orderBy('id', 'desc')
                                    ->first();

                $nextId = $lastRecord ? ($lastRecord->id + 1) : 1;
                
                $model->id_permintaan = 'BHN-' . $tahun . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}