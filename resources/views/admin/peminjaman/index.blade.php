@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Data Peminjaman
            </h3>

            <p class="text-muted mb-0">
                Kelola pengajuan peminjaman barang TITL
            </p>
        </div>

    </div>


    {{-- PESAN SUCCESS --}}
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


    {{-- PESAN ERROR --}}
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


    {{-- VALIDATION ERROR --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- CARD TABLE --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>No</th>

                            <th>Kode</th>

                            <th>Pengguna</th>

                            <th>Barang</th>

                            <th>Jumlah</th>

                            <th>Tanggal Pinjam</th>

                            <th>Rencana Kembali</th>

                            <th>Status Pengajuan</th>

                            <th>Aksi</th>

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


                                {{-- USER --}}

                                <td>

                                    <div class="fw-semibold">
                                        {{ $peminjaman->user->name ?? '-' }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $peminjaman->user->username ?? '-' }}
                                    </small>

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


                                {{-- AKSI --}}

                                <td>

                                    @if($peminjaman->status_pengajuan === 'menunggu')

                                        <div class="d-flex gap-2">

                                            {{-- SETUJUI --}}

                                            <form
                                                action="{{ route('admin.peminjaman.setujui', $peminjaman->id) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="btn btn-success btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')"
                                                >

                                                    Setujui

                                                </button>

                                            </form>


                                            {{-- TOLAK --}}

                                            <button
                                                type="button"
                                                class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#tolakModal{{ $peminjaman->id }}"
                                            >

                                                Tolak

                                            </button>

                                        </div>


                                    @elseif($peminjaman->status_pengajuan === 'disetujui')

                                        <span class="text-success fw-semibold">

                                            ✓ Sudah Disetujui

                                        </span>


                                    @elseif($peminjaman->status_pengajuan === 'ditolak')

                                        <span class="text-danger fw-semibold">

                                            ✕ Sudah Ditolak

                                        </span>

                                    @endif

                                </td>

                            </tr>


                            {{-- MODAL TOLAK --}}

                            <div
                                class="modal fade"
                                id="tolakModal{{ $peminjaman->id }}"
                                tabindex="-1"
                                aria-hidden="true"
                            >

                                <div class="modal-dialog">

                                    <div class="modal-content">


                                        <form
                                            action="{{ route('admin.peminjaman.tolak', $peminjaman->id) }}"
                                            method="POST"
                                        >

                                            @csrf


                                            <div class="modal-header">

                                                <h5 class="modal-title">
                                                    Tolak Peminjaman
                                                </h5>

                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                ></button>

                                            </div>


                                            <div class="modal-body">

                                                <div class="mb-3">

                                                    <label class="form-label fw-semibold">

                                                        Pengguna

                                                    </label>

                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        value="{{ $peminjaman->user->name ?? '-' }}"
                                                        readonly
                                                    >

                                                </div>


                                                <div class="mb-3">

                                                    <label class="form-label fw-semibold">

                                                        Kode Peminjaman

                                                    </label>

                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        value="{{ $peminjaman->kode_peminjaman }}"
                                                        readonly
                                                    >

                                                </div>


                                                <div class="mb-3">

                                                    <label class="form-label fw-semibold">

                                                        Alasan Penolakan

                                                    </label>

                                                    <textarea
                                                        name="alasan_penolakan"
                                                        class="form-control"
                                                        rows="4"
                                                        placeholder="Masukkan alasan penolakan..."
                                                        required
                                                    ></textarea>

                                                </div>

                                            </div>


                                            <div class="modal-footer">

                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal"
                                                >

                                                    Batal

                                                </button>


                                                <button
                                                    type="submit"
                                                    class="btn btn-danger"
                                                >

                                                    Tolak Peminjaman

                                                </button>

                                            </div>


                                        </form>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center py-5"
                                >

                                    <div class="text-muted">

                                        Belum ada data peminjaman.

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