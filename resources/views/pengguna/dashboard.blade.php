<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Pengguna - TITL</title>

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

        .navbar h2 {
            font-size: 22px;
        }

        .navbar span {
            font-size: 14px;
        }

        .container {
            padding: 35px 40px;
        }

        .welcome {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        }

        .welcome h1 {
            color: #1e3a8a;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #666;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-decoration: none;
            color: #333;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            transition: 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.10);
        }

        .icon {
            font-size: 35px;
            margin-bottom: 15px;
        }

        .card h3 {
            margin-bottom: 8px;
            color: #1e3a8a;
        }

        .card p {
            font-size: 14px;
            color: #777;
        }

        .logout {
            margin-top: 30px;
        }

        .logout button {
            background: #dc2626;
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 8px;
            cursor: pointer;
        }

        .logout button:hover {
            background: #b91c1c;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>TITL</h2>

        <span>
            👤 {{ Auth::user()->name }}
        </span>
    </div>

    <div class="container">

        <div class="welcome">
            <h1>Selamat Datang 👋</h1>

            <p>
                Selamat datang di Sistem Peminjaman Barang TITL.
                Silakan pilih menu yang ingin digunakan.
            </p>
        </div>

        <div class="menu">

            <a href="{{ route('pengguna.barang') }}" class="card">
                <div class="icon">📦</div>
                <h3>Daftar Barang</h3>
                <p>Lihat barang TITL yang tersedia untuk dipinjam.</p>
            </a>

            <a href="{{ route('pengguna.peminjaman.index') }}" class="card">
                <div class="icon">📋</div>
                <h3>Peminjaman Saya</h3>
                <p>Lihat daftar peminjaman yang pernah diajukan.</p>
            </a>

            <a href="{{ route('pengguna.peminjaman.create') }}" class="card">
                <div class="icon">➕</div>
                <h3>Ajukan Peminjaman</h3>
                <p>Buat pengajuan peminjaman barang baru.</p>
            </a>

            <a href="{{ route('pengguna.pengembalian.index') }}" class="card">

                <div class="icon">🔄</div>

                <h3>Pengembalian</h3>

                <p>
        Ajukan pengembalian barang yang sedang dipinjam.
    </p>

</a>

        </div>

        <div class="logout">

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit">
                    🚪 Logout
                </button>
            </form>

        </div>

    </div>

</body>
</html>