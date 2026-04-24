<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat', 150);
            $table->enum('bentuk_sediaan', [
                'tablet',
                'kapsul',
                'sirup',
                'salep',
                'krim',
                'injeksi',
                'sachet',
                'lainnya',
            ]);
            $table->string('kekuatan_dosis', 50);
            $table->unsignedInteger('stok')->default(0);
            $table->timestamps();

            $table->index('nama_obat');
            $table->index('bentuk_sediaan');
            $table->index('stok');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
