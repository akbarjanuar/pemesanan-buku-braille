<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pencetakans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->string('kode_cetak'); // Contoh: CEK-2025-0002
            $table->string('jenis_literasi')->default('Literasi Manual'); // Literasi Manual / Literasi Digital
            $table->string('pic'); // Penanggung Jawab / PIC
            $table->integer('target_buku'); // Jumlah target buku
            $table->integer('buku_selesai')->default(0); // Progress buku yang sudah selesai
            $table->date('deadline');
            $table->string('status')->default('Menunggu Bahan'); // Menunggu Bahan, Diproses, Selesai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pencetakans');
    }
};