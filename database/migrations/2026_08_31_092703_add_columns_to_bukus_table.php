<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Gunakan nama tabel 'buku' sesuai di Supabase
        Schema::table('buku', function (Blueprint $table) {
            if (!Schema::hasColumn('buku', 'penerbit')) {
                $table->string('penerbit')->nullable();
            }
            if (!Schema::hasColumn('buku', 'batas_pemesanan')) {
                $table->integer('batas_pemesanan')->default(1);
            }
            if (!Schema::hasColumn('buku', 'isbn')) {
                $table->string('isbn')->nullable();
            }
            if (!Schema::hasColumn('buku', 'tahun_terbit')) {
                $table->integer('tahun_terbit')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn(['penerbit', 'batas_pemesanan', 'isbn', 'tahun_terbit']);
        });
    }
};