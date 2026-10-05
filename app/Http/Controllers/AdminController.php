<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;

class AdminController extends Controller
{
    public function dashboard()
    {
        $jumlahBarang = Barang::count();

        $stokBarang = Barang::sum('stok');

        $jumlahPeminjaman = Peminjaman::count();

        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();

        return view('admin.dashboard', compact(
            'jumlahBarang',
            'stokBarang',
            'jumlahPeminjaman',
            'peminjamanAktif'
        ));
    }
}