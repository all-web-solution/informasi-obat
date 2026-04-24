<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasi_obats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')
                ->constrained('obats')
                ->cascadeOnDelete();

            $table->text('indikasi_penyakit');
            $table->text('efek_samping_umum');
            $table->text('tanda_bahaya');

            $table->text('interaksi_obat');
            $table->text('interaksi_makanan');

            $table->enum('penyimpanan_suhu', ['rak', 'kulkas']);
            $table->boolean('hindari_cahaya')->default(false);
            $table->boolean('hindari_kelembaban')->default(false);

            $table->boolean('tidak_hentikan_mendadak')->default(false);
            $table->boolean('harus_dihabiskan')->default(false);
            $table->text('cara_penggunaan_khusus')->nullable();

            $table->timestamps();

            $table->unique('obat_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_obats');
    }
};
