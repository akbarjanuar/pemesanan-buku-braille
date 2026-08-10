<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    use HasFactory;
    protected $table = 'pesanan_detail';
    protected $fillable = ['pesanan_id', 'buku_id', 'jumlah'];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}