<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>

    <style>
        body {
            font-family: Arial;
            background: #f3f4f6;
            margin: 0;
        }

        .container {
            width: 90%;
            margin: 40px auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .button {
            background: #2563eb;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background: #2563eb;
            color: white;
        }

        .edit {
            background: #f59e0b;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .delete {
            background: #dc2626;
            color: white;
            padding: 6px 10px;
            border: 0;
            border-radius: 5px;
            cursor: pointer;
        }

        .success {
            background: #dcfce7;
            padding: 12px;
            margin-top: 15px;
        }

        .error {
            background: #fee2e2;
            padding: 12px;
            margin-top: 15px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">

        <h1>Data Barang</h1>

        <a href="{{ route('admin.barang.create') }}" class="button">
            + Tambah Barang
        </a>

    </div>

    <a href="{{ route('admin.dashboard') }}">
        ← Kembali ke Dashboard
    </a>

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

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Kondisi</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        @forelse($barangs as $barang)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $barang->kode_barang }}</td>

                <td>{{ $barang->nama_barang }}</td>

                <td>{{ $barang->kategori }}</td>

                <td>{{ $barang->stok }}</td>

                <td>{{ $barang->kondisi }}</td>

                <td>

                    <a
                        href="{{ route('admin.barang.edit', $barang) }}"
                        class="edit"
                    >
                        Edit
                    </a>

                    <form
                        action="{{ route('admin.barang.destroy', $barang) }}"
                        method="POST"
                        style="display:inline"
                        onsubmit="return confirm('Yakin ingin menghapus barang ini?')"
                    >

                        @csrf
                        @method('DELETE')

                        <button class="delete">
                            Hapus
                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="7" style="text-align:center">
                    Belum ada data barang.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

</body>
</html>