<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->string('nama_penerima')->nullable()->after('jenis_pesanan');
            $table->string('telepon')->nullable()->after('nama_penerima');
            $table->text('alamat_lengkap')->nullable()->after('telepon');
            $table->string('kota')->nullable()->after('alamat_lengkap');
            $table->string('kode_pos')->nullable()->after('kota');
            $table->text('catatan')->nullable()->after('kode_pos');
        });
    }
 
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['nama_penerima', 'telepon', 'alamat_lengkap', 'kota', 'kode_pos', 'catatan']);
        });
    }
};
 
