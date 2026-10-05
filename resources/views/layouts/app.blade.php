<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $title ?? 'TITL Peminjaman' }}
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        nav {
            background: #0f172a;
            color: white;
            padding: 16px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
        }

        .container {
            max-width: 1150px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow:
                0 3px 12px rgba(0,0,0,.08);
        }

        .grid {
            display: grid;
            grid-template-columns:
                repeat(
                    auto-fit,
                    minmax(200px,1fr)
                );
            gap: 20px;
        }

        .stat {
            font-size: 30px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom:
                1px solid #e2e8f0;
            text-align: left;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px;
            margin:
                6px 0 15px;
            border:
                1px solid #cbd5e1;
            border-radius: 7px;
        }

        button,
        .btn {
            border: none;
            background: #2563eb;
            color: white;
            padding: 10px 15px;
            border-radius: 7px;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-success {
            background: #16a34a;
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-secondary {
            background: #64748b;
        }

        .alert {
            background: #dbeafe;
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 15px;
        }

        .alert-danger {
            background: #fee2e2;
        }

        .badge {
            background: #e2e8f0;
            padding: 5px 10px;
            border-radius: 20px;
        }

    </style>

</head>

<body>

<nav>

    <div>

        <a href="/">
            <strong>
                TITL INVENTARIS
            </strong>
        </a>

        @auth

            @if(
                auth()->user()->role === 'admin'
            )

                <a
                    href="{{ route('admin.dashboard') }}"
                >
                    Dashboard
                </a>

                <a
                    href="{{ route('admin.barang.index') }}"
                >
                    Barang
                </a>

                <a
                    href="{{ route('admin.peminjaman.index') }}"
                >
                    Transaksi
                </a>

            @else

                <a
                    href="{{ route('pengguna.dashboard') }}"
                >
                    Dashboard
                </a>

                <a
                    href="{{ route('pengguna.barang') }}"
                >
                    Daftar Barang
                </a>

                <a
                    href="{{ route('pengguna.peminjaman.index') }}"
                >
                    Peminjaman
                </a>

            @endif

        @endauth

    </div>


    @auth

        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button class="btn-secondary">
                Logout
            </button>

        </form>

    @endauth

</nav>


<div class="container">

    @if(session('success'))

        <div class="alert">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger">

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    @yield('content')

</div>

</body>

</html>