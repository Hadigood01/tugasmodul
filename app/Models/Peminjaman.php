<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
    'kode_peminjaman',
    'user_id',
    'tanggal_pinjam',
    'tanggal_rencana_kembali',
    'tanggal_kembali',
    'status',
    'status_pengajuan',
    'alasan_penolakan',
    'dikonfirmasi_at',
    'total_denda',
    'catatan',
];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_rencana_kembali' => 'date',
        'tanggal_kembali' => 'date',
        'total_denda' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }
}