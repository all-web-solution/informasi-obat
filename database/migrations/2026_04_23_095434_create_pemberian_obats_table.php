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
        Schema::create('pemberian_obats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained()->onDelete('cascade');
            $table->text('obat');

            // Aturan pakai
            $table->integer('berapa_kali_sehari');
            $table->enum('sebelum_sesudah_makan', ['sebelum makan', 'sesudah makan', 'tidak berpengaruh']);
            $table->integer('lama_penggunaan_hari');

            $table->text('informasi_tambahan')->nullable();
            $table->date('tanggal_pemberian');
            $table->text('diagnosa_keluhan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemberian_obats');
    }
};
