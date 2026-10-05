<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN - DAFTAR BARANG
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $barangs = Barang::orderBy('nama_barang')->get();

        return view(
            'admin.barang.index',
            compact('barangs')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - FORM TAMBAH
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.barang.create');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - SIMPAN BARANG
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kategori' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request
                ->file('gambar')
                ->store('barang', 'public');
        }

        Barang::create($data);

        return redirect()
            ->route('admin.barang.index')
            ->with(
                'success',
                'Barang berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - DETAIL BARANG
    |--------------------------------------------------------------------------
    */

    public function show(Barang $barang)
    {
        return view(
            'admin.barang.show',
            compact('barang')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - FORM EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Barang $barang)
    {
        return view(
            'admin.barang.edit',
            compact('barang')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - UPDATE BARANG
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Barang $barang
    ) {
        $data = $request->validate([
            'kode_barang' =>
                'required|string|max:50|unique:barangs,kode_barang,' . $barang->id,

            'nama_barang' =>
                'required|string|max:255',

            'gambar' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'kategori' =>
                'required|string|max:100',

            'stok' =>
                'required|integer|min:0',

            'kondisi' =>
                'required|in:baik,rusak_ringan,rusak_berat',

            'keterangan' =>
                'nullable|string|max:1000',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Jika upload gambar baru
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('gambar')) {

            if (
                $barang->gambar &&
                Storage::disk('public')->exists($barang->gambar)
            ) {
                Storage::disk('public')->delete(
                    $barang->gambar
                );
            }

            $data['gambar'] = $request
                ->file('gambar')
                ->store('barang', 'public');
        }

        $barang->update($data);

        return redirect()
            ->route('admin.barang.index')
            ->with(
                'success',
                'Data barang berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - HAPUS BARANG
    |--------------------------------------------------------------------------
    */

    public function destroy(Barang $barang)
    {
        if (
            $barang->gambar &&
            Storage::disk('public')->exists($barang->gambar)
        ) {
            Storage::disk('public')->delete(
                $barang->gambar
            );
        }

        $barang->delete();

        return redirect()
            ->route('admin.barang.index')
            ->with(
                'success',
                'Barang berhasil dihapus.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | PENGGUNA - DAFTAR BARANG
    |--------------------------------------------------------------------------
    */

    public function penggunaIndex()
    {
        $barangs = Barang::where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();

        return view(
            'pengguna.barang.index',
            compact('barangs')
        );
    }
}