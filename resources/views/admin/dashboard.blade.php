<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard Admin TITL</title>

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

        .navbar h2 {
            margin: 0;
        }

        .container {
            padding: 30px;

            max-width: 1200px;

            margin: auto;
        }

        .welcome {
            margin-bottom: 25px;
        }

        .cards {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 20px;
        }

        .card {
            background: white;

            padding: 25px;

            border-radius: 12px;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, .08);
        }

        .card h3 {
            margin-top: 0;

            color: #64748b;
        }

        .number {
            font-size: 32px;

            font-weight: bold;

            color: #2563eb;
        }

        .menu {
            margin-top: 30px;

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;
        }

        .menu a {
            display: block;

            background: white;

            padding: 25px;

            border-radius: 12px;

            text-decoration: none;

            color: #1e293b;

            font-weight: bold;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, .08);

            transition: .2s;
        }

        .menu a:hover {
            background: #2563eb;

            color: white;

            transform: translateY(-2px);
        }

        .logout {
            background: #dc2626;

            color: white;

            border: none;

            padding: 9px 15px;

            border-radius: 6px;

            cursor: pointer;
        }

        .logout:hover {
            background: #b91c1c;
        }

        @media(max-width: 800px) {

            .cards,
            .menu {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


<!-- NAVBAR -->

<div class="navbar">

    <h2>
        Sistem Peminjaman Barang TITL
    </h2>


    <form
        method="POST"
        action="{{ route('logout') }}"
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


<!-- CONTENT -->

<div class="container">


    <div class="welcome">

        <h1>
            Dashboard Admin
        </h1>

        <p>
            Selamat datang,
            <strong>
                {{ auth()->user()->name }}
            </strong>
        </p>

    </div>


    <!-- STATISTIK -->

    <div class="cards">


        <div class="card">

            <h3>
                Jumlah Barang
            </h3>

            <div class="number">
                {{ $jumlahBarang }}
            </div>

        </div>


        <div class="card">

            <h3>
                Total Stok
            </h3>

            <div class="number">
                {{ $stokBarang }}
            </div>

        </div>


        <div class="card">

            <h3>
                Total Peminjaman
            </h3>

            <div class="number">
                {{ $jumlahPeminjaman }}
            </div>

        </div>


        <div class="card">

            <h3>
                Sedang Dipinjam
            </h3>

            <div class="number">
                {{ $peminjamanAktif }}
            </div>

        </div>


    </div>


    <!-- MENU -->

    <div class="menu">

    <a href="{{ route('admin.barang.index') }}">
        📦 Kelola Barang
    </a>

    <a href="{{ route('admin.peminjaman.index') }}">
        📋 Data Peminjaman
    </a>

    <a href="{{ route('admin.pengembalian.index') }}">
        🔄 Pengembalian
    </a>

    <a href="{{ route('admin.denda.index') }}">
        💰 Denda
    </a>

    <a href="{{ route('admin.laporan.index') }}">
        📊 Laporan
    </a>

    <a href="{{ route('pengguna.dashboard') }}">
        👤 Halaman Pengguna
    </a>

</div>


</div>


</body>

</html>