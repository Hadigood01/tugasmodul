<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            CREATE TRIGGER after_peminjaman_detail_insert
            AFTER INSERT ON peminjaman_details
            FOR EACH ROW
            BEGIN
                UPDATE barangs
                SET stok = stok - NEW.jumlah
                WHERE id = NEW.barang_id;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER after_peminjaman_detail_update
            AFTER UPDATE OF jumlah_kembali ON peminjaman_details
            FOR EACH ROW
            BEGIN
                UPDATE barangs
                SET stok = stok + (NEW.jumlah_kembali - OLD.jumlah_kembali)
                WHERE id = NEW.barang_id;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared(
            'DROP TRIGGER IF EXISTS after_peminjaman_detail_insert'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS after_peminjaman_detail_update'
        );
    }
};