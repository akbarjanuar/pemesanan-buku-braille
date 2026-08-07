<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('pengarang');
            $table->string('kategori'); // Agama, Fiksi, Sains, Pendidikan, Non-Fiksi, Sejarah, Seni & Budaya
            $table->integer('stok')->default(0);
            $table->string('warna_cover')->default('#37474f'); // Kode warna hex untuk warna cover card
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
