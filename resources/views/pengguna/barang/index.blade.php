<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Daftar Barang - TITL</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            font-family: Arial, Helvetica, sans-serif;

            background: #f3f6fa;

            color: #172337;
        }

        /* NAVBAR */

        .navbar {

            height: 70px;

            background: #101827;

            color: white;

            display: flex;

            align-items: center;

            padding: 0 6%;

            gap: 25px;

        }

        .brand {

            font-size: 17px;

            font-weight: bold;

            margin-right: 5px;

        }

        .nav-link {

            color: white;

            text-decoration: none;

            font-size: 15px;

        }

        .nav-link:hover {

            color: #60a5fa;

        }

        .logout {

            margin-left: auto;

            background: #64748b;

            color: white;

            padding: 10px 18px;

            border-radius: 7px;

            text-decoration: none;

            font-size: 13px;

        }

        /* CONTAINER */

        .container {

            max-width: 1080px;

            margin: 32px auto;

            padding: 0 20px;

        }

        .title {

            margin-bottom: 25px;

        }

        .title h1 {

            margin: 0 0 8px;

            font-size: 25px;

        }

        .title p {

            margin: 0;

            color: #64748b;

            font-size: 14px;

        }

        /* BUTTON */

        .btn-pinjam {

            display: inline-block;

            background: #2563eb;

            color: white;

            text-decoration: none;

            padding: 11px 17px;

            border-radius: 7px;

            font-size: 14px;

            font-weight: bold;

            margin-bottom: 18px;

        }

        .btn-pinjam:hover {

            background: #1d4ed8;

        }

        /* TABLE CARD */

        .table-card {

            background: white;

            border-radius: 15px;

            box-shadow:
                0 5px 18px rgba(15, 23, 42, .07);

            overflow: hidden;

        }

        .table-wrapper {

            overflow-x: auto;

        }

        table {

            width: 100%;

            border-collapse: collapse;

        }

        th {

            padding: 17px 16px;

            background: #ffffff;

            border-bottom: 1px solid #dbe2ea;

            text-align: left;

            font-size: 14px;

            color: #172337;

            white-space: nowrap;

        }

        td {

            padding: 13px 16px;

            border-bottom: 1px solid #e2e8f0;

            font-size: 14px;

            vertical-align: middle;

        }

        tr:last-child td {

            border-bottom: none;

        }

        /* FOTO */

        .foto-barang {

            width: 70px;

            height: 70px;

            border-radius: 10px;

            object-fit: cover;

            border: 1px solid #e2e8f0;

            display: block;

        }

        .foto-placeholder {

            width: 70px;

            height: 70px;

            border-radius: 10px;

            background: #f1f5f9;

            border: 1px solid #e2e8f0;

            display: flex;

            align-items: center;

            justify-content: center;

            color: #94a3b8;

            font-size: 24px;

        }

        /* KODE */

        .kode {

            font-weight: bold;

            color: #1e293b;

        }

        /* STOK */

        .stok {

            display: inline-flex;

            min-width: 34px;

            height: 30px;

            padding: 0 9px;

            border-radius: 20px;

            align-items: center;

            justify-content: center;

            background: #e8edf5;

            color: #334155;

        }

        /* KONDISI */

        .kondisi {

            text-transform: capitalize;

        }

        .kondisi-baik {

            color: #15803d;

            font-weight: bold;

        }

        .kondisi-rusak {

            color: #dc2626;

            font-weight: bold;

        }

        /* EMPTY */

        .empty {

            text-align: center;

            padding: 50px;

            color: #94a3b8;

        }

        /* MOBILE */

        @media (max-width: 700px) {

            .navbar {

                padding: 0 15px;

                gap: 12px;

            }

            .brand {

                font-size: 14px;

            }

            .nav-link {

                font-size: 13px;

            }

            .container {

                margin-top: 25px;

            }

        }

    </style>

</head>


<body>


{{-- NAVBAR --}}

<nav class="navbar">

    <div class="brand">
        TITL INVENTARIS
    </div>

    <a href="{{ route('pengguna.dashboard') }}"
       class="nav-link">
        Dashboard
    </a>

    <a href="{{ route('pengguna.barang') }}"
       class="nav-link">
        Daftar Barang
    </a>

    <a href="{{ route('pengguna.peminjaman.index') }}"
       class="nav-link">
        Peminjaman
    </a>

    <a href="{{ route('logout') }}"
       class="logout"
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


{{-- CONTENT --}}

<div class="container">


    <div class="title">

        <h1>
            Daftar Barang
        </h1>

        <p>
            Barang yang tersedia untuk dipinjam
        </p>

    </div>


    <a href="{{ route('pengguna.peminjaman.create') }}"
       class="btn-pinjam">

        + Ajukan Peminjaman

    </a>


    <div class="table-card">

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>
                            No
                        </th>

                        <th>
                            Foto
                        </th>

                        <th>
                            Kode Barang
                        </th>

                        <th>
                            Nama Barang
                        </th>

                        <th>
                            Kategori
                        </th>

                        <th>
                            Stok
                        </th>

                        <th>
                            Kondisi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($barangs as $barang)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- FOTO --}}

                            <td>

                                @if($barang->gambar)

                                    <img
                                        src="{{ asset('storage/' . $barang->gambar) }}"
                                        alt="{{ $barang->nama_barang }}"
                                        class="foto-barang"
                                    >

                                @else

                                    <div class="foto-placeholder">
                                        📦
                                    </div>

                                @endif

                            </td>


                            {{-- KODE --}}

                            <td>

                                <span class="kode">
                                    {{ $barang->kode_barang }}
                                </span>

                            </td>


                            {{-- NAMA --}}

                            <td>

                                {{ $barang->nama_barang }}

                            </td>


                            {{-- KATEGORI --}}

                            <td>

                                {{ $barang->kategori }}

                            </td>


                            {{-- STOK --}}

                            <td>

                                <span class="stok">
                                    {{ $barang->stok }}
                                </span>

                            </td>


                            {{-- KONDISI --}}

                            <td>

                                @if($barang->kondisi === 'baik')

                                    <span class="kondisi kondisi-baik">
                                        Baik
                                    </span>

                                @else

                                    <span class="kondisi kondisi-rusak">
                                        {{ str_replace('_', ' ', $barang->kondisi) }}
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="empty">

                                Belum ada barang yang tersedia.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


</body>

</html>