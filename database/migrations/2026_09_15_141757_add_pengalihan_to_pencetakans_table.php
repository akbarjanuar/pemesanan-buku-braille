<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pencetakans', function (Blueprint $table) {
            $table->string('alihkan_kepada')->nullable();
            $table->string('alasan_pengalihan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pencetakans', function (Blueprint $table) {
            //
        });
    }
};
