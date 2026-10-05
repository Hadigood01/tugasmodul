<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Denda - TITL</title>

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

            box-shadow:
                0 4px 15px rgba(0,0,0,.08);

            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px;

            border-bottom:
                1px solid #e5e7eb;

            text-align: left;
        }

        th {
            background: #f8fafc;
        }

        .denda {
            color: #dc2626;
            font-weight: bold;
        }

        .status {
            padding: 6px 10px;
            border-radius: 6px;

            background: #fee2e2;
            color: #991b1b;
        }

        .logout {
            background: #dc2626;
            color: white;

            border: none;

            padding: 9px 15px;

            border-radius: 6px;

            cursor: pointer;
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
        Data Denda
    </h1>


    <div class="card">

        <table>

            <thead>

                <tr>

                    <th>No</th>

                    <th>Kode Peminjaman</th>

                    <th>Peminjam</th>

                    <th>Tanggal Pinjam</th>

                    <th>Tanggal Kembali</th>

                    <th>Status</th>

                    <th>Total Denda</th>

                </tr>

            </thead>


            <tbody>

            @forelse($peminjamans as $peminjaman)

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
                        {{ $peminjaman->tanggal_pinjam }}
                    </td>

                    <td>
                        {{ $peminjaman->tanggal_kembali ?? '-' }}
                    </td>

                    <td>

                        <span class="status">
                            {{ $peminjaman->status }}
                        </span>

                    </td>

                    <td class="denda">

                        Rp
                        {{ number_format(
                            $peminjaman->total_denda,
                            0,
                            ',',
                            '.'
                        ) }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="7"
                        style="text-align:center;"
                    >
                        Belum ada data denda.
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>


        <div style="margin-top:20px;">

            {{ $peminjamans->links() }}

        </div>

    </div>

</div>

</body>

</html>