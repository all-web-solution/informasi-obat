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
        Schema::create('informasi_obats', function (Blueprint $table) {
            $table->id();

            // Indikasi
            $table->text('obat');
            $table->text('indikasi_penyakit');
            $table->text('efek_samping_umum');
            $table->text('tanda_bahaya');

            // Interaksi
            $table->text('interaksi_obat');
            $table->text('interaksi_makanan');

            // Penyimpanan
            $table->enum('penyimpanan_suhu', ['rak', 'kulkas']);
            $table->boolean('hindari_cahaya')->default(false);
            $table->boolean('hindari_kelembaban')->default(false);

            // Hal khusus
            $table->boolean('tidak_hentikan_mendadak')->default(false);
            $table->boolean('harus_dihabiskan')->default(false);
            $table->text('cara_penggunaan_khusus')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_obats');
    }
};
