@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}

    <div class="mb-4">

        <h3 class="fw-bold mb-1">
            Peminjaman Saya
        </h3>

        <p class="text-muted mb-0">
            Daftar pengajuan dan peminjaman barang TITL
        </p>

    </div>


    {{-- SUCCESS --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- ERROR --}}

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- DATA PEMINJAMAN --}}

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>No</th>

                            <th>Kode</th>

                            <th>Barang</th>

                            <th>Jumlah</th>

                            <th>Tanggal Pinjam</th>

                            <th>Rencana Kembali</th>

                            <th>Status Pengajuan</th>

                            <th>Status Barang</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($peminjamans as $index => $peminjaman)

                            <tr>

                                {{-- NO --}}

                                <td>

                                    {{ $peminjamans->firstItem() + $index }}

                                </td>


                                {{-- KODE --}}

                                <td>

                                    <span class="fw-semibold">

                                        {{ $peminjaman->kode_peminjaman }}

                                    </span>

                                </td>


                                {{-- BARANG --}}

                                <td>

                                    @foreach($peminjaman->details as $detail)

                                        <div>

                                            {{ $detail->barang->nama_barang ?? '-' }}

                                        </div>

                                    @endforeach

                                </td>


                                {{-- JUMLAH --}}

                                <td>

                                    @foreach($peminjaman->details as $detail)

                                        <div>

                                            {{ $detail->jumlah }}

                                        </div>

                                    @endforeach

                                </td>


                                {{-- TANGGAL PINJAM --}}

                                <td>

                                    {{ $peminjaman->tanggal_pinjam?->format('d/m/Y') ?? '-' }}

                                </td>


                                {{-- TANGGAL RENCANA KEMBALI --}}

                                <td>

                                    {{ $peminjaman->tanggal_rencana_kembali?->format('d/m/Y') ?? '-' }}

                                </td>


                                {{-- STATUS PENGAJUAN --}}

                                <td>

                                    @if($peminjaman->status_pengajuan === 'menunggu')

                                        <span class="badge bg-warning text-dark">

                                            Menunggu Konfirmasi

                                        </span>


                                    @elseif($peminjaman->status_pengajuan === 'disetujui')

                                        <span class="badge bg-success">

                                            Disetujui

                                        </span>


                                    @elseif($peminjaman->status_pengajuan === 'ditolak')

                                        <span class="badge bg-danger">

                                            Ditolak

                                        </span>


                                        @if($peminjaman->alasan_penolakan)

                                            <div class="mt-2">

                                                <small class="text-danger">

                                                    <strong>
                                                        Alasan:
                                                    </strong>

                                                    {{ $peminjaman->alasan_penolakan }}

                                                </small>

                                            </div>

                                        @endif


                                    @else

                                        <span class="badge bg-secondary">

                                            Tidak diketahui

                                        </span>

                                    @endif

                                </td>


                                {{-- STATUS BARANG --}}

                                <td>

                                    @if(
                                        $peminjaman->status_pengajuan === 'menunggu'
                                    )

                                        <span class="badge bg-secondary">

                                            Belum Dipinjam

                                        </span>


                                    @elseif(
                                        $peminjaman->status_pengajuan === 'ditolak'
                                    )

                                        <span class="badge bg-danger">

                                            Pengajuan Ditolak

                                        </span>


                                    @elseif(
                                        $peminjaman->status === 'dipinjam'
                                    )

                                        <span class="badge bg-primary">

                                            Sedang Dipinjam

                                        </span>


                                    @elseif(
                                        $peminjaman->status === 'menunggu_pengembalian'
                                    )

                                        <span class="badge bg-warning text-dark">

                                            Menunggu Pengembalian

                                        </span>


                                    @elseif(
                                        $peminjaman->status === 'dikembalikan'
                                    )

                                        <span class="badge bg-success">

                                            Dikembalikan

                                        </span>


                                    @endif

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td
                                    colspan="8"
                                    class="text-center py-5"
                                >

                                    <div class="text-muted">

                                        Belum ada pengajuan peminjaman.

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}

            <div class="mt-3">

                {{ $peminjamans->links() }}

            </div>

        </div>

    </div>

</div>

@endsection