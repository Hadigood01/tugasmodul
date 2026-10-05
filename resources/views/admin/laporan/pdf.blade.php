<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Laporan Transaksi TITL</title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 15px;
        }

        .header p {
            margin: 3px 0;
        }

        .summary {
            width: 100%;
            margin-bottom: 20px;
        }

        .summary td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        .summary-title {
            font-weight: bold;
            font-size: 10px;
        }

        .summary-value {
            font-size: 14px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #1e293b;
            color: white;
            padding: 8px;
            border: 1px solid #333;
            text-align: center;
        }

        td {
            padding: 7px;
            border: 1px solid #ccc;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .footer {
            margin-top: 25px;
            text-align: right;
            font-size: 10px;
        }

        .denda {
            font-weight: bold;
        }

    </style>

</head>

<body>

    <div class="header">

        <h1>SISTEM PEMINJAMAN BARANG TITL</h1>

        <h2>LAPORAN TRANSAKSI PEMINJAMAN</h2>

        <p>
            Dicetak pada:
            {{ date('d-m-Y H:i') }}
        </p>

    </div>


    <table class="summary">

        <tr>

            <td>
                <div class="summary-title">
                    TOTAL PEMINJAMAN
                </div>

                <div class="summary-value">
                    {{ $totalPeminjaman }}
                </div>
            </td>

            <td>
                <div class="summary-title">
                    SEDANG DIPINJAM
                </div>

                <div class="summary-value">
                    {{ $totalDipinjam }}
                </div>
            </td>

            <td>
                <div class="summary-title">
                    SUDAH DIKEMBALIKAN
                </div>

                <div class="summary-value">
                    {{ $totalDikembalikan }}
                </div>
            </td>

            <td>
                <div class="summary-title">
                    TOTAL DENDA
                </div>

                <div class="summary-value">
                    Rp {{ number_format($totalDenda, 0, ',', '.') }}
                </div>
            </td>

        </tr>

    </table>


    <table>

        <thead>

            <tr>

                <th width="4%">
                    No
                </th>

                <th width="15%">
                    Kode Peminjaman
                </th>

                <th width="12%">
                    Peminjam
                </th>

                <th width="18%">
                    Barang
                </th>

                <th width="7%">
                    Jumlah
                </th>

                <th width="10%">
                    Tgl Pinjam
                </th>

                <th width="10%">
                    Rencana Kembali
                </th>

                <th width="10%">
                    Tgl Kembali
                </th>

                <th width="8%">
                    Status
                </th>

                <th width="10%">
                    Denda
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($peminjamans as $peminjaman)

                @foreach($peminjaman->details as $detail)

                    <tr>

                        <td class="center">
                            {{ $loop->parent->iteration }}
                        </td>

                        <td>
                            {{ $peminjaman->kode_peminjaman }}
                        </td>

                        <td>
                            {{ $peminjaman->user->name ?? '-' }}
                        </td>

                        <td>
                            {{ $detail->barang->nama_barang ?? '-' }}
                        </td>

                        <td class="center">
                            {{ $detail->jumlah }}
                        </td>

                        <td class="center">
                            {{ $peminjaman->tanggal_pinjam
                                ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y')
                                : '-' }}
                        </td>

                        <td class="center">
                            {{ $peminjaman->tanggal_rencana_kembali
                                ? \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d-m-Y')
                                : '-' }}
                        </td>

                        <td class="center">
                            {{ $peminjaman->tanggal_kembali
                                ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y')
                                : '-' }}
                        </td>

                        <td class="center">
                            {{ ucfirst(str_replace('_', ' ', $peminjaman->status)) }}
                        </td>

                        <td class="right denda">
                            Rp {{ number_format($peminjaman->total_denda ?? 0, 0, ',', '.') }}
                        </td>

                    </tr>

                @endforeach

            @empty

                <tr>

                    <td colspan="10" class="center">
                        Belum ada transaksi peminjaman.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    <div class="footer">

        <p>
            Sistem Peminjaman Barang TITL
        </p>

        <p>
            Laporan ini dibuat secara otomatis oleh sistem.
        </p>

    </div>

</body>

</html>