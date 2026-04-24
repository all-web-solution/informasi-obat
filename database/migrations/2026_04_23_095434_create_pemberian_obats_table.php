<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemberian_obats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pasien_id')
                ->constrained('pasiens')
                ->cascadeOnDelete();

            $table->foreignId('obat_id')
                ->constrained('obats')
                ->restrictOnDelete();

            $table->unsignedInteger('jumlah')->default(1);
            $table->unsignedTinyInteger('berapa_kali_sehari');
            $table->enum('sebelum_sesudah_makan', [
                'sebelum makan',
                'sesudah makan',
                'tidak berpengaruh'
            ]);

            $table->unsignedSmallInteger('lama_penggunaan_hari');
            $table->text('informasi_tambahan')->nullable();
            $table->date('tanggal_pemberian');
            $table->text('diagnosa_keluhan');

            $table->timestamps();

            $table->index(['pasien_id', 'tanggal_pemberian']);
            $table->index(['obat_id', 'tanggal_pemberian']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemberian_obats');
    }
};
