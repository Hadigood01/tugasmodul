<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';

    protected $fillable = [
        'peminjaman_id',
        'tanggal_kembali',
        'terlambat_hari',
        'denda_per_hari',
        'total_denda',
        'kondisi_kembali',
        'catatan',
    ];

    protected $casts = [
        'tanggal_kembali' => 'date',
        'denda_per_hari' => 'decimal:2',
        'total_denda' => 'decimal:2',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}