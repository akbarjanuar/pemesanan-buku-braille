<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permintaan_bahans', function (Blueprint $table) {
            $table->id();
            $table->string('id_permintaan')->unique()->nullable(); // Contoh: BHN-2026-0001
            $table->string('divisi'); // Literasi Manual / Literasi Digital
            $table->string('nama_bahan'); // Kertas Braille, dll
            $table->integer('jumlah');
            $table->string('satuan'); // Lembar, Roll, dll
            $table->text('keperluan');
            $table->string('status')->default('Menunggu diproses'); // Status berjalannya
            $table->string('pengaju')->nullable(); // Nama orang yang mengajukan
            $table->string('prioritas')->default('Normal'); // Normal / Tinggi
            $table->text('catatan_kendala')->nullable(); // Jika ada kendala
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permintaan_bahans');
    }
};