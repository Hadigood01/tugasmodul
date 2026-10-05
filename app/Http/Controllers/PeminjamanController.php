<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PENGGUNA - DAFTAR PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $peminjamans = Peminjaman::with([
            'user',
            'details.barang',
            'pengembalian'
        ])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view(
            'pengguna.peminjaman.index',
            compact('peminjamans')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PENGGUNA - FORM PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $barangs = Barang::where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();

        return view(
            'pengguna.peminjaman.create',
            compact('barangs')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PENGGUNA - AJUKAN PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal_pinjam' =>
                'required|date',

            'tanggal_rencana_kembali' =>
                'required|date|after_or_equal:tanggal_pinjam',

            'catatan' =>
                'nullable|string|max:1000',

            'items' =>
                'required|array|min:1',

            'items.*.barang_id' =>
                'required|exists:barangs,id',

            'items.*.jumlah' =>
                'required|integer|min:1',
        ]);

        try {

            DB::transaction(function () use ($data) {

                $kode =
                    'PJM-' .
                    date('YmdHis') .
                    '-' .
                    strtoupper(substr(uniqid(), -4));

                $peminjaman = Peminjaman::create([
                    'kode_peminjaman' =>
                        $kode,

                    'user_id' =>
                        Auth::id(),

                    'tanggal_pinjam' =>
                        $data['tanggal_pinjam'],

                    'tanggal_rencana_kembali' =>
                        $data['tanggal_rencana_kembali'],

                    'status' =>
                        'dipinjam',

                    'status_pengajuan' =>
                        'menunggu',

                    'alasan_penolakan' =>
                        null,

                    'dikonfirmasi_at' =>
                        null,

                    'total_denda' =>
                        0,

                    'catatan' =>
                        $data['catatan'] ?? null,
                ]);


                foreach ($data['items'] as $item) {

                    $barang = Barang::findOrFail(
                        $item['barang_id']
                    );

                    if (
                        $item['jumlah'] >
                        $barang->stok
                    ) {
                        throw new \Exception(
                            'Stok ' .
                            $barang->nama_barang .
                            ' tidak mencukupi.'
                        );
                    }

                    $peminjaman->details()->create([
                        'barang_id' =>
                            $item['barang_id'],

                        'jumlah' =>
                            $item['jumlah'],

                        'jumlah_kembali' =>
                            0,
                    ]);
                }
            });


            return redirect()
                ->route('pengguna.peminjaman.index')
                ->with(
                    'success',
                    'Pengajuan peminjaman berhasil dikirim. Silakan menunggu konfirmasi admin.'
                );

        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | PENGGUNA - DETAIL PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load([
            'user',
            'details.barang',
            'pengembalian'
        ]);

        if (
            Auth::user()->role !== 'admin' &&
            $peminjaman->user_id !== Auth::id()
        ) {
            abort(403);
        }

        return view(
            'pengguna.peminjaman.show',
            compact('peminjaman')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PENGGUNA - HALAMAN PENGEMBALIAN
    |--------------------------------------------------------------------------
    */

    public function pengembalianPenggunaIndex()
    {
        $peminjamans = Peminjaman::with([
            'details.barang',
            'pengembalian'
        ])
            ->where('user_id', Auth::id())
            ->where('status_pengajuan', 'disetujui')
            ->whereIn('status', [
                'dipinjam',
                'menunggu_pengembalian'
            ])
            ->latest()
            ->paginate(10);

        return view(
            'pengguna.pengembalian.index',
            compact('peminjamans')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PENGGUNA - AJUKAN PENGEMBALIAN
    |--------------------------------------------------------------------------
    */

    public function ajukanPengembalian(
        Peminjaman $peminjaman
    ) {
        if (
            $peminjaman->user_id !== Auth::id()
        ) {
            abort(403);
        }

        if (
            $peminjaman->status_pengajuan !== 'disetujui'
        ) {
            return back()->with(
                'error',
                'Peminjaman belum disetujui admin.'
            );
        }

        if (
            $peminjaman->status !== 'dipinjam'
        ) {
            return back()->with(
                'error',
                'Peminjaman ini sudah diajukan atau sudah dikembalikan.'
            );
        }

        $peminjaman->update([
            'status' =>
                'menunggu_pengembalian',
        ]);

        return back()->with(
            'success',
            'Pengajuan pengembalian berhasil dikirim. Silakan menunggu konfirmasi admin.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - DATA PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function adminIndex()
    {
        $peminjamans = Peminjaman::with([
            'user',
            'details.barang',
            'pengembalian'
        ])
            ->latest()
            ->paginate(10);

        return view(
            'admin.peminjaman.index',
            compact('peminjamans')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - SETUJUI PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function setujuiPeminjaman(
        Peminjaman $peminjaman
    ) {
        if (
            $peminjaman->status_pengajuan !== 'menunggu'
        ) {
            return back()->with(
                'error',
                'Peminjaman ini sudah diproses.'
            );
        }

        try {

            DB::transaction(function () use ($peminjaman) {

                $peminjaman->load('details.barang');

                foreach ($peminjaman->details as $detail) {

                    $barang = Barang::where(
                        'id',
                        $detail->barang_id
                    )
                        ->lockForUpdate()
                        ->first();

                    if (!$barang) {
                        throw new \Exception(
                            'Barang tidak ditemukan.'
                        );
                    }

                    if (
                        $detail->jumlah >
                        $barang->stok
                    ) {
                        throw new \Exception(
                            'Stok ' .
                            $barang->nama_barang .
                            ' tidak mencukupi untuk menyetujui peminjaman.'
                        );
                    }

                    $barang->decrement(
                        'stok',
                        $detail->jumlah
                    );
                }

                $peminjaman->update([
                    'status_pengajuan' =>
                        'disetujui',

                    'dikonfirmasi_at' =>
                        now(),

                    'alasan_penolakan' =>
                        null,
                ]);
            });


            return back()->with(
                'success',
                'Peminjaman berhasil disetujui. Stok barang telah dikurangi.'
            );

        } catch (\Throwable $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - TOLAK PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function tolakPeminjaman(
        Request $request,
        Peminjaman $peminjaman
    ) {
        $data = $request->validate([
            'alasan_penolakan' =>
                'required|string|max:1000',
        ]);

        if (
            $peminjaman->status_pengajuan !== 'menunggu'
        ) {
            return back()->with(
                'error',
                'Peminjaman ini sudah diproses.'
            );
        }

        $peminjaman->update([
            'status_pengajuan' =>
                'ditolak',

            'alasan_penolakan' =>
                $data['alasan_penolakan'],

            'dikonfirmasi_at' =>
                now(),
        ]);

        return back()->with(
            'success',
            'Peminjaman berhasil ditolak.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - HALAMAN PENGEMBALIAN
    |--------------------------------------------------------------------------
    */

    public function pengembalianIndex()
    {
        $peminjamans = Peminjaman::with([
            'user',
            'details.barang',
            'pengembalian'
        ])
            ->where('status_pengajuan', 'disetujui')
            ->whereIn('status', [
                'dipinjam',
                'menunggu_pengembalian'
            ])
            ->latest()
            ->paginate(10);

        return view(
            'admin.pengembalian.index',
            compact('peminjamans')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - HALAMAN DENDA
    |--------------------------------------------------------------------------
    */

    public function dendaIndex()
    {
        $peminjamans = Peminjaman::with([
            'user',
            'details.barang',
            'pengembalian'
        ])
            ->where('total_denda', '>', 0)
            ->latest()
            ->paginate(10);

        return view(
            'admin.denda.index',
            compact('peminjamans')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - HALAMAN LAPORAN
    |--------------------------------------------------------------------------
    */

    public function laporanIndex()
    {
        $totalPeminjaman =
            Peminjaman::count();

        $totalDipinjam =
            Peminjaman::where(
                'status',
                'dipinjam'
            )
                ->where(
                    'status_pengajuan',
                    'disetujui'
                )
                ->count();

        $totalDikembalikan =
            Peminjaman::where(
                'status',
                'dikembalikan'
            )->count();

        $totalDenda =
            Peminjaman::sum(
                'total_denda'
            );

        $peminjamans =
            Peminjaman::with([
                'user',
                'details.barang',
                'pengembalian'
            ])
                ->latest()
                ->paginate(10);

        return view(
            'admin.laporan.index',
            compact(
                'totalPeminjaman',
                'totalDipinjam',
                'totalDikembalikan',
                'totalDenda',
                'peminjamans'
            )
        );
    }


/*
|--------------------------------------------------------------------------
| ADMIN - CETAK LAPORAN PDF
|--------------------------------------------------------------------------
*/

public function laporanPdf()
{
    $peminjamans = Peminjaman::with([
        'user',
        'details.barang',
        'pengembalian'
    ])
        ->latest()
        ->get();

    $totalPeminjaman = Peminjaman::count();

    $totalDipinjam = Peminjaman::where(
        'status',
        'dipinjam'
    )
        ->where(
            'status_pengajuan',
            'disetujui'
        )
        ->count();

    $totalDikembalikan = Peminjaman::where(
        'status',
        'dikembalikan'
    )->count();

    $totalDenda = Peminjaman::sum(
        'total_denda'
    );

    $pdf = Pdf::loadView(
        'admin.laporan.pdf',
        compact(
            'peminjamans',
            'totalPeminjaman',
            'totalDipinjam',
            'totalDikembalikan',
            'totalDenda'
        )
    );

    $pdf->setPaper('a4', 'landscape');

    return $pdf->download(
        'laporan-transaksi-TITL-' . date('Y-m-d') . '.pdf'
    );
}


    /*
    |--------------------------------------------------------------------------
    | ADMIN - PROSES PENGEMBALIAN + DENDA
    |--------------------------------------------------------------------------
    */

    public function pengembalian(
        Request $request,
        Peminjaman $peminjaman
    ) {
        $data = $request->validate([
            'tanggal_kembali' =>
                'required|date',

            'catatan' =>
                'nullable|string|max:1000',
        ]);

        if (
            $peminjaman->status === 'dikembalikan'
        ) {
            return back()->with(
                'error',
                'Peminjaman ini sudah dikembalikan.'
            );
        }

        if (
            $peminjaman->status_pengajuan !== 'disetujui'
        ) {
            return back()->with(
                'error',
                'Peminjaman belum disetujui admin.'
            );
        }

        try {

            $totalDenda = 0;

DB::transaction(function () use (
    $peminjaman,
    $data,
    &$totalDenda
) {

                /*
                |--------------------------------------------------------------------------
                | TANGGAL
                |--------------------------------------------------------------------------
                */

                $tanggalKembali = Carbon::parse(
                    $data['tanggal_kembali']
                );

                $tanggalRencana = Carbon::parse(
                    $peminjaman->tanggal_rencana_kembali
                );


                /*
                |--------------------------------------------------------------------------
                | HITUNG KETERLAMBATAN
                |--------------------------------------------------------------------------
                */

                $terlambat = 0;

                if (
                    $tanggalKembali->greaterThan(
                        $tanggalRencana
                    )
                ) {

                    $terlambat = $tanggalRencana->diffInDays(
                        $tanggalKembali
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | HITUNG DENDA
                |--------------------------------------------------------------------------
                |
                | Rp10.000 setiap hari terlambat.
                |
                */

                $dendaPerHari = 10000;

                $totalDenda =
                    $terlambat *
                    $dendaPerHari;


                /*
                |--------------------------------------------------------------------------
                | UPDATE DETAIL DAN STOK
                |--------------------------------------------------------------------------
                */

                $peminjaman->load(
                    'details.barang'
                );

                foreach (
                    $peminjaman->details as $detail
                ) {

                    $detail->update([
                        'jumlah_kembali' =>
                            $detail->jumlah,
                    ]);

                    $barang =
                        $detail->barang;

                    if ($barang) {

                        $barang->increment(
                            'stok',
                            $detail->jumlah
                        );
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | UPDATE PEMINJAMAN
                |--------------------------------------------------------------------------
                */

                $peminjaman->update([
                    'status' =>
                        'dikembalikan',

                    'tanggal_kembali' =>
                        $tanggalKembali->toDateString(),

                    'total_denda' =>
                        $totalDenda,

                    'catatan' =>
                        $data['catatan'] ?? null,
                ]);


                /*
                |--------------------------------------------------------------------------
                | SIMPAN DATA PENGEMBALIAN
                |--------------------------------------------------------------------------
                */

                $peminjaman->pengembalian()->create([
                    'tanggal_kembali' =>
                        $tanggalKembali->toDateString(),

                    'terlambat_hari' =>
                        $terlambat,

                    'denda_per_hari' =>
                        $dendaPerHari,

                    'total_denda' =>
                        $totalDenda,

                    'kondisi_kembali' =>
                        'baik',

                    'catatan' =>
                        $data['catatan'] ?? null,
                ]);
            });


            /*
            |--------------------------------------------------------------------------
            | PESAN HASIL
            |--------------------------------------------------------------------------
            */

            $pesanDenda = $totalDenda > 0
                ? 'Total denda: Rp ' .
                    number_format(
                        $totalDenda,
                        0,
                        ',',
                        '.'
                    )
                : 'Tidak ada denda.';

            return back()->with(
                'success',
                'Pengembalian berhasil diproses. ' .
                $pesanDenda
            );

        } catch (\Throwable $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}