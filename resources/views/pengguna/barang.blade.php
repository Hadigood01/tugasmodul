<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Daftar Barang - TITL</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .navbar {
            background: #1e293b;
            color: white;

            padding: 18px 40px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
        }

        .back {
            color: white;
            text-decoration: none;
        }

        .container {
            padding: 35px 40px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            margin-bottom: 8px;
        }

        .header p {
            color: #64748b;
        }

        .grid {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(220px, 1fr));

            gap: 20px;
        }

        .card {
            background: white;

            padding: 25px;

            border-radius: 12px;

            box-shadow:
                0 3px 10px rgba(0, 0, 0, .08);
        }

        .icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .card h2 {
            margin-bottom: 10px;
        }

        .category {
            color: #64748b;
            margin-bottom: 15px;
        }

        .stock {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .available {
            color: #16a34a;
        }

        .borrow {
            display: inline-block;

            background: #2563eb;

            color: white;

            text-decoration: none;

            padding: 10px 18px;

            border-radius: 6px;
        }

        .borrow:hover {
            background: #1d4ed8;
        }

        .empty {
            background: white;

            padding: 40px;

            text-align: center;

            border-radius: 10px;
        }

        @media (max-width: 800px) {

            .grid {
                grid-template-columns: 1fr 1fr;
            }

        }

        @media (max-width: 550px) {

            .grid {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 25px 20px;
            }

        }

    </style>

</head>

<body>


<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">
        📦 TITL
    </div>

    <a
        href="{{ route('pengguna.dashboard') }}"
        class="back"
    >
        ← Dashboard
    </a>

</div>


<!-- CONTENT -->

<div class="container">

    <div class="header">

        <h1>
            Daftar Barang
        </h1>

        <p>
            Barang TITL yang tersedia untuk dipinjam.
        </p>

    </div>


    @if($barangs->count() > 0)

        <div class="grid">

            @foreach($barangs as $barang)

                <div class="card">

                    <div class="icon">
                        📦
                    </div>

                    <h2>
                        {{ $barang->nama_barang }}
                    </h2>

                    <p class="category">
                        Kode:
                        {{ $barang->kode_barang }}
                    </p>

                    <p class="category">
                        Kategori:
                        {{ $barang->kategori }}
                    </p>

                    <p class="stock available">
                        Stok tersedia:
                        {{ $barang->stok }}
                    </p>

                    <a
                        href="{{ route('pengguna.peminjaman.create') }}"
                        class="borrow"
                    >
                        Pinjam
                    </a>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty">

            <h2>
                Tidak ada barang tersedia
            </h2>

            <p>
                Saat ini belum ada barang yang dapat dipinjam.
            </p>

        </div>

    @endif

</div>


</body>

</html>