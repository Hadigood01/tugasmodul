<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Pengembalian - TITL</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
        }

        .navbar {
            background: #1e293b;
            color: white;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 30px;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #2563eb;
            font-weight: bold;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f8fafc;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 6px;
            background: #fef3c7;
            color: #92400e;
        }

        .form-kembali {
            min-width: 220px;
        }

        .form-kembali label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            font-size: 13px;
        }

        .form-kembali input,
        .form-kembali textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-family: Arial, sans-serif;
        }

        .form-kembali textarea {
            min-height: 60px;
            resize: vertical;
        }

        .btn-kembali {
            background: #2563eb;
            color: white;
            border: none;
            padding: 9px 12px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
        }

        .btn-kembali:hover {
            background: #1d4ed8;
        }

        .logout {
            background: #dc2626;
            color: white;
            border: none;
            padding: 9px 15px;
            border-radius: 6px;
            cursor: pointer;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

    </style>

</head>

<body>

<div class="navbar">

    <strong>
        Sistem Peminjaman Barang TITL
    </strong>

    <form
        action="{{ route('logout') }}"
        method="POST"
    >
        @csrf

        <button
            type="submit"
            class="logout"
        >
            Logout
        </button>

    </form>

</div>


<div class="container">

    <a
        href="{{ route('admin.dashboard') }}"
        class="back"
    >
        ← Kembali ke Dashboard
    </a>


    <h1>
        Pengembalian Barang
    </h1>


    @if(session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="error">
            {{ session('error') }}
        </div>

    @endif


    <div class="card">

        <table>

            <thead>

                <tr>

                    <th>No</th>

                    <th>Kode Peminjaman</th>

                    <th>Peminjam</th>

                    <th>Barang</th>

                    <th>Jumlah</th>

                    <th>Tanggal Pinjam</th>

                    <th>Status</th>

                    <th>Aksi</th>

                </tr>

            </thead>


            <tbody>

            @forelse($peminjamans as $peminjaman)

                @foreach($peminjaman->details as $detail)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
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

                        <td>
                            {{ $detail->jumlah }}
                        </td>

                        <td>
                            {{ $peminjaman->tanggal_pinjam }}
                        </td>

                        <td>

                            <span class="status">
                                {{ $peminjaman->status }}
                            </span>

                        </td>

                        <td>

                            <form
                                action="{{ route('admin.pengembalian.proses', $peminjaman->id) }}"
                                method="POST"
                                class="form-kembali"
                            >

                                @csrf

                                <label>
                                    Tanggal Pengembalian
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_kembali"
                                    value="{{ date('Y-m-d') }}"
                                    required
                                >


                                <label>
                                    Catatan
                                </label>

                                <textarea
                                    name="catatan"
                                    placeholder="Catatan pengembalian (opsional)"
                                ></textarea>


                                <button
                                    type="submit"
                                    class="btn-kembali"
                                >
                                    🔄 Konfirmasi Pengembalian
                                </button>

                            </form>

                        </td>

                    </tr>

                @endforeach

            @empty

                <tr>

                    <td
                        colspan="8"
                        style="text-align: center;"
                    >
                        Tidak ada barang yang sedang dipinjam.
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>


        <div style="margin-top: 20px;">

            {{ $peminjamans->links() }}

        </div>

    </div>

</div>

</body>

</html>