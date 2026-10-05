<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class PenggunaController extends Controller
{
    public function dashboard()
    {
        return view('pengguna.dashboard');
    }

    public function barang()
    {
        $barangs = Barang::where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();

        return view('pengguna.barang', compact('barangs'));
    }
}