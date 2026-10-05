<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'gambar',
        'kategori',
        'stok',
        'kondisi',
        'keterangan',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}