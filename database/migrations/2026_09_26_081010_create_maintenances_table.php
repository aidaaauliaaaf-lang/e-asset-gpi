<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnDelete();

            $table->date('tanggal_maintenance');

            $table->string('jenis_maintenance');

            $table->text('keterangan')->nullable();

            $table->string('penanggung_jawab')->nullable();

            $table->enum('status', [
                'Terjadwal',
                'Proses',
                'Selesai'
            ])->default('Terjadwal');

            $table->date('tanggal_maintenance_berikutnya')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};