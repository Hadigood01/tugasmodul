<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pengembalian - TITL</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f7fb;
            color: #333;
        }

        .navbar {
            background: #1e3a8a;
            color: white;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        .container {
            padding: 35px 40px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            color: #1e3a8a;
            margin-bottom: 8px;
        }

        .header p {
            color: #666;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .kode {
            font-weight: bold;
            color: #1e3a8a;
        }

        .status {
            padding: 7px 12px;
            border-radius: 20px;
            background: #fef3c7;
            color: #92400e;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f8fafc;
        }

        .btn {
            background: #1e3a8a;
            color: white;
            border: none;
            padding: 11px 18px;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn:hover {
            background: #172554;
        }

        .empty {
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 15px;
            color: #777;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #1e3a8a;
        }
    </style>
</head>

<body>

    <div class="navbar">

        <h2>TITL</h2>

        <div>
            👤 {{ Auth::user()->name }}

            <a href="{{ route('pengguna.dashboard') }}">
                Dashboard
            </a>
        </div>

    </div>

    <div class="container">

        <a href="{{ route('pengguna.dashboard') }}" class="back">
            ← Kembali ke Dashboard
        </a>

        <div class="header">
            <h1>Pengembalian Barang</h1>

            <p>
                Ajukan pengembalian barang yang sedang kamu pinjam.
            </p>
        </div>

        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif

        @forelse($peminjamans as $peminjaman)

            <div class="card">

                <div class="card-header">

                    <div>
                        <div class="kode">
                            {{ $peminjaman->kode_peminjaman }}
                        </div>

                        <small>
                            Tanggal pinjam:
                            {{ $peminjaman->tanggal_pinjam }}
                        </small>
                    </div>

                    <span class="status">
                        {{ ucfirst($peminjaman->status) }}
                    </span>

                </div>

                <table>

                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($peminjaman->details as $detail)

                            <tr>
                                <td>
                                    {{ $detail->barang->nama_barang }}
                                </td>

                                <td>
                                    {{ $detail->jumlah }}
                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

                <form
                    action="{{ route(
                        'pengguna.pengembalian.ajukan',
                        $peminjaman->id
                    ) }}"
                    method="POST"
                    onsubmit="return confirm('Ajukan pengembalian untuk peminjaman ini?')"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn"
                    >
                        🔄 Ajukan Pengembalian
                    </button>

                </form>

            </div>

        @empty

            <div class="empty">

                <h3>Tidak ada barang yang sedang dipinjam</h3>

                <p>
                    Semua peminjaman kamu sudah dikembalikan
                    atau belum ada peminjaman aktif.
                </p>

            </div>

        @endforelse

        {{ $peminjamans->links() }}

    </div>

</body>

</html>