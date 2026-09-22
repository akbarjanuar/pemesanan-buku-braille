<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pic extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'nomor_telepon'];

    /**
     * Relasi ke tabel pencetakan berdasarkan nama PIC.
     */
    public function pencetakan()
    {
        return $this->hasMany(Pencetakan::class, 'pic', 'nama');
    }
}