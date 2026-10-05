<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->string('status_pengajuan')
                ->default('menunggu')
                ->after('status');

            $table->text('alasan_penolakan')
                ->nullable()
                ->after('status_pengajuan');

            $table->timestamp('dikonfirmasi_at')
                ->nullable()
                ->after('alasan_penolakan');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn([
                'status_pengajuan',
                'alasan_penolakan',
                'dikonfirmasi_at',
            ]);
        });
    }
};