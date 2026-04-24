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

            $table->text('obat_aturan_pakai');
            $table->date('tanggal_pemberian');
            $table->text('diagnosa_keluhan');
            $table->text('informasi_tambahan')->nullable();

            $table->timestamps();

            $table->index(['pasien_id', 'tanggal_pemberian']);
            $table->index('tanggal_pemberian');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemberian_obats');
    }
};
