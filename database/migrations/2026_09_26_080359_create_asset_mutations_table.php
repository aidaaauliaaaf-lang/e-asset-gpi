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
Schema::create('asset_mutations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnDelete();

            $table->string('lokasi_asal')->nullable();
            $table->string('lokasi_tujuan')->nullable();

            $table->string('divisi_asal')->nullable();
            $table->string('divisi_tujuan')->nullable();

            $table->string('penanggung_jawab_lama')->nullable();
            $table->string('penanggung_jawab_baru')->nullable();

            $table->date('tanggal_mutasi');

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_mutations');
    }
};
