<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Transaksi - TITL</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f7fb;
            color: #1e293b;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            height: 70px;
            background: #172337;
            color: white;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 30px;
        }

        .navbar-title {
            display: flex;
            align-items: center;
            gap: 12px;

            font-size: 18px;
            font-weight: bold;
        }

        .navbar-icon {
            width: 38px;
            height: 38px;

            background: #2563eb;
            border-radius: 9px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 19px;
        }

        .logout-btn {
            background: #ef3340;
            color: white;

            text-decoration: none;

            padding: 11px 20px;
            border-radius: 7px;

            font-size: 14px;
            font-weight: bold;

            transition: 0.2s;
        }

        .logout-btn:hover {
            background: #dc2633;
        }

        /* =========================
           CONTAINER
        ========================= */

        .container {
            max-width: 1180px;
            margin: auto;
            padding: 32px 24px 50px;
        }

        /* =========================
           BREADCRUMB
        ========================= */

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 9px;

            margin-bottom: 25px;

            font-size: 14px;
        }

        .breadcrumb a {
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }

        .breadcrumb span {
            color: #94a3b8;
        }

        .breadcrumb-current {
            color: #475569;
        }

        /* =========================
           HEADER LAPORAN
        ========================= */

        .report-header {
            background: white;

            border-radius: 16px;

            padding: 28px 32px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 25px;

            box-shadow: 0 5px 20px rgba(15, 23, 42, 0.07);

            margin-bottom: 30px;
        }

        .report-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .report-icon {
            width: 78px;
            height: 78px;

            flex-shrink: 0;

            background: #dbeafe;
            color: #2563eb;

            border-radius: 15px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 36px;
        }

        .report-info h1 {
            margin: 0 0 7px;

            font-size: 29px;
            color: #172337;
        }

        .report-info p {
            margin: 0 0 13px;

            color: #64748b;
            font-size: 15px;
        }

        .period {
            display: flex;
            align-items: center;
            gap: 7px;

            color: #334155;
            font-size: 14px;
            font-weight: bold;
        }

        /* =========================
           PDF BUTTON
        ========================= */

        .pdf-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;

            background: #ef2635;
            color: white;

            text-decoration: none;

            padding: 14px 21px;

            border-radius: 9px;

            font-size: 15px;
            font-weight: bold;

            white-space: nowrap;

            transition: 0.2s;
        }

        .pdf-btn:hover {
            background: #d91f2d;
            transform: translateY(-1px);
        }

        /* =========================
           SECTION TITLE
        ========================= */

        .section-title {
            margin-bottom: 18px;
        }

        .section-title h2 {
            margin: 0 0 5px;

            font-size: 20px;
            color: #172337;
        }

        .section-title p {
            margin: 0;

            color: #64748b;
            font-size: 14px;
        }

        /* =========================
           STATISTIC CARDS
        ========================= */

        .stats {
            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 20px;

            margin-bottom: 30px;
        }

        .stat-card {
            background: white;

            min-height: 175px;

            padding: 24px;

            border-radius: 15px;

            box-shadow: 0 5px 18px rgba(15, 23, 42, 0.06);

            border: 1px solid #e2e8f0;

            position: relative;

            overflow: hidden;
        }

        .stat-card::after {
            content: "";

            position: absolute;

            right: -25px;
            bottom: -30px;

            width: 100px;
            height: 100px;

            border-radius: 50%;

            opacity: 0.08;
        }

        .stat-top {
            display: flex;
            align-items: center;

            gap: 14px;

            margin-bottom: 17px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 21px;
        }

        .stat-title {
            font-size: 14px;
            font-weight: bold;

            color: #475569;
        }

        .stat-value {
            font-size: 30px;
            font-weight: bold;

            margin-bottom: 9px;
        }

        .stat-description {
            font-size: 12px;

            line-height: 1.5;

            color: #94a3b8;
        }

        /* BLUE */

        .stat-blue {
            border-color: #bfdbfe;
        }

        .stat-blue .stat-icon {
            background: #dbeafe;
            color: #2563eb;
        }

        .stat-blue .stat-value {
            color: #2563eb;
        }

        .stat-blue::after {
            background: #2563eb;
        }

        /* GREEN */

        .stat-green {
            border-color: #bbf7d0;
        }

        .stat-green .stat-icon {
            background: #dcfce7;
            color: #16a34a;
        }

        .stat-green .stat-value {
            color: #16a34a;
        }

        .stat-green::after {
            background: #16a34a;
        }

        /* PURPLE */

        .stat-purple {
            border-color: #ddd6fe;
        }

        .stat-purple .stat-icon {
            background: #ede9fe;
            color: #7c3aed;
        }

        .stat-purple .stat-value {
            color: #7c3aed;
        }

        .stat-purple::after {
            background: #7c3aed;
        }

        /* RED */

        .stat-red {
            border-color: #fecaca;
        }

        .stat-red .stat-icon {
            background: #fee2e2;
            color: #dc2626;
        }

        .stat-red .stat-value {
            color: #dc2626;
        }

        .stat-red::after {
            background: #dc2626;
        }

        /* =========================
           DATA TRANSAKSI
        ========================= */

        .transaction-card {
            background: white;

            border-radius: 15px;

            box-shadow: 0 5px 18px rgba(15, 23, 42, 0.06);

            overflow: hidden;
        }

        .transaction-header {
            padding: 22px 24px;

            border-bottom: 1px solid #e2e8f0;

            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .transaction-header h3 {
            margin: 0;

            font-size: 18px;
        }

        .transaction-header span {
            font-size: 13px;
            color: #64748b;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;

            color: #475569;

            font-size: 12px;

            text-align: left;

            padding: 14px 16px;

            border-bottom: 1px solid #e2e8f0;

            white-space: nowrap;
        }

        td {
            padding: 15px 16px;

            border-bottom: 1px solid #f1f5f9;

            font-size: 13px;

            color: #334155;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .status {
            display: inline-block;

            padding: 5px 10px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: bold;
        }

        .status-dipinjam {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-dikembalikan {
            background: #dcfce7;
            color: #15803d;
        }

        .status-menunggu {
            background: #fef3c7;
            color: #b45309;
        }

        .status-ditolak {
            background: #fee2e2;
            color: #b91c1c;
        }

        .empty {
            text-align: center;

            padding: 45px;

            color: #94a3b8;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 950px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .report-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .pdf-btn {
                width: 100%;
            }
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 0 15px;
            }

            .navbar-title {
                font-size: 14px;
            }

            .container {
                padding: 25px 15px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .report-info {
                align-items: flex-start;
            }

            .report-info h1 {
                font-size: 23px;
            }

            .report-icon {
                width: 60px;
                height: 60px;
                font-size: 27px;
            }
        }
    </style>
</head>

<body>

    {{-- =========================
         NAVBAR
    ========================== --}}
    <nav class="navbar">

        <div class="navbar-title">
            <div class="navbar-icon">
                📋
            </div>

            <span>
                Sistem Peminjaman Barang TITL
            </span>
        </div>

        <a href="{{ route('logout') }}"
           class="logout-btn"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form"
              action="{{ route('logout') }}"
              method="POST"
              style="display:none;">
            @csrf
        </form>

    </nav>


    {{-- =========================
         MAIN
    ========================== --}}
    <main class="container">

        {{-- Breadcrumb --}}
        <div class="breadcrumb">

            <a href="{{ route('admin.dashboard') }}">
                ← Dashboard
            </a>

            <span>›</span>

            <div class="breadcrumb-current">
                Laporan Transaksi
            </div>

        </div>


        {{-- =========================
             HEADER LAPORAN
        ========================== --}}
        <section class="report-header">

            <div class="report-info">

                <div class="report-icon">
                    📊
                </div>

                <div>

                    <h1>
                        Laporan Transaksi Peminjaman
                    </h1>

                    <p>
                        Rekap seluruh transaksi peminjaman barang TITL,
                        termasuk status, tanggal, dan denda.
                    </p>

                    <div class="period">
                        📅
                        <span>
                            Periode laporan : Semua Data
                        </span>
                    </div>

                </div>

            </div>


            {{-- Tombol PDF --}}
            <a href="{{ route('admin.laporan.pdf') }}"
               target="_blank"
               class="pdf-btn">

                📄
                <span>Cetak Laporan PDF</span>

            </a>

        </section>


        {{-- =========================
             JUDUL RINGKASAN
        ========================== --}}
        <div class="section-title">

            <h2>
                Ringkasan Laporan
            </h2>

            <p>
                Informasi singkat mengenai seluruh transaksi peminjaman barang TITL.
            </p>

        </div>


        {{-- =========================
             STATISTIK
        ========================== --}}
        <section class="stats">


            {{-- TOTAL PEMINJAMAN --}}
            <div class="stat-card stat-blue">

                <div class="stat-top">

                    <div class="stat-icon">
                        📋
                    </div>

                    <div class="stat-title">
                        Total Peminjaman
                    </div>

                </div>

                <div class="stat-value">
                    {{ $totalPeminjaman }}
                </div>

                <div class="stat-description">
                    Jumlah seluruh transaksi peminjaman.
                </div>

            </div>


            {{-- SEDANG DIPINJAM --}}
            <div class="stat-card stat-green">

                <div class="stat-top">

                    <div class="stat-icon">
                        ↪
                    </div>

                    <div class="stat-title">
                        Sedang Dipinjam
                    </div>

                </div>

                <div class="stat-value">
                    {{ $totalDipinjam }}
                </div>

                <div class="stat-description">
                    Transaksi yang masih dalam proses peminjaman.
                </div>

            </div>


            {{-- SUDAH DIKEMBALIKAN --}}
            <div class="stat-card stat-purple">

                <div class="stat-top">

                    <div class="stat-icon">
                        ✓
                    </div>

                    <div class="stat-title">
                        Sudah Dikembalikan
                    </div>

                </div>

                <div class="stat-value">
                    {{ $totalDikembalikan }}
                </div>

                <div class="stat-description">
                    Transaksi yang sudah selesai dikembalikan.
                </div>

            </div>


            {{-- TOTAL DENDA --}}
            <div class="stat-card stat-red">

                <div class="stat-top">

                    <div class="stat-icon">
                        Rp
                    </div>

                    <div class="stat-title">
                        Total Denda
                    </div>

                </div>

                <div class="stat-value">
                    Rp {{ number_format($totalDenda, 0, ',', '.') }}
                </div>

                <div class="stat-description">
                    Total denda dari keterlambatan pengembalian.
                </div>

            </div>

        </section>


        {{-- =========================
             DATA TRANSAKSI
        ========================== --}}
        <section class="transaction-card">

            <div class="transaction-header">

                <h3>
                    Data Transaksi
                </h3>

                <span>
                    {{ $peminjamans->total() }} transaksi
                </span>

            </div>


            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>
                                Kode Peminjaman
                            </th>

                            <th>
                                Peminjam
                            </th>

                            <th>
                                Barang
                            </th>

                            <th>
                                Tanggal Pinjam
                            </th>

                            <th>
                                Rencana Kembali
                            </th>

                            <th>
                                Tanggal Kembali
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Denda
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($peminjamans as $peminjaman)

                            @foreach($peminjaman->details as $detail)

                                <tr>

                                    <td>
                                        {{ ($peminjamans->currentPage() - 1) * $peminjamans->perPage() + $loop->parent->iteration }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $peminjaman->kode_peminjaman }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $peminjaman->user->name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $detail->barang->nama_barang ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $peminjaman->tanggal_pinjam
                                            ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y')
                                            : '-' }}
                                    </td>

                                    <td>
                                        {{ $peminjaman->tanggal_rencana_kembali
                                            ? \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d-m-Y')
                                            : '-' }}
                                    </td>

                                    <td>
                                        {{ $peminjaman->tanggal_kembali
                                            ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y')
                                            : '-' }}
                                    </td>

                                    <td>

                                        @php
                                            $statusClass = match ($peminjaman->status) {
                                                'dipinjam' => 'status-dipinjam',
                                                'dikembalikan' => 'status-dikembalikan',
                                                'menunggu_pengembalian' => 'status-menunggu',
                                                default => 'status-ditolak',
                                            };
                                        @endphp

                                        <span class="status {{ $statusClass }}">

                                            {{ ucfirst(str_replace('_', ' ', $peminjaman->status)) }}

                                        </span>

                                    </td>

                                    <td>

                                        <strong>
                                            Rp {{ number_format($peminjaman->total_denda ?? 0, 0, ',', '.') }}
                                        </strong>

                                    </td>

                                </tr>

                            @endforeach

                        @empty

                            <tr>

                                <td colspan="9" class="empty">

                                    Belum ada transaksi peminjaman.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>


        {{-- Pagination --}}
        <div style="margin-top: 25px;">
            {{ $peminjamans->links() }}
        </div>

    </main>

</body>
</html>