<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peminjaman_id')
                ->unique()
                ->constrained('peminjamans')
                ->cascadeOnDelete();

            $table->date('tanggal_kembali');
            $table->unsignedInteger('terlambat_hari')->default(0);
            $table->decimal('denda_per_hari', 12, 2)->default(5000);
            $table->decimal('total_denda', 12, 2)->default(0);

            $table->enum('kondisi_kembali', [
                'baik',
                'rusak_ringan',
                'rusak_berat'
            ])->default('baik');

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};