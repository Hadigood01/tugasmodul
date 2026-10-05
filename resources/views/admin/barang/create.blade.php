<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Barang - TITL</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1e293b;
        }

        .navbar {
            height: 70px;
            background: #111827;
            color: white;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 30px;
        }

        .navbar-title {
            font-size: 18px;
            font-weight: bold;
        }

        .logout {
            background: #ef4444;
            color: white;
            padding: 10px 18px;
            border-radius: 7px;
            text-decoration: none;
        }

        .container {
            max-width: 800px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,.06);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            font-size: 14px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 14px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
        }

        .help {
            color: #64748b;
            font-size: 12px;
            margin-top: 5px;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 7px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background: #1d4ed8;
        }
    </style>
</head>

<body>

<nav class="navbar">

    <div class="navbar-title">
        TITL INVENTARIS
    </div>

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

<div class="container">

    <a href="{{ route('admin.barang.index') }}" class="back">
        ← Kembali ke Daftar Barang
    </a>

    <div class="card">

        <h1>Tambah Barang</h1>

        <form action="{{ route('admin.barang.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="form-group">

                <label>Kode Barang</label>

                <input
                    type="text"
                    name="kode_barang"
                    value="{{ old('kode_barang') }}"
                    placeholder="Contoh: BRG003"
                    required
                >

                @error('kode_barang')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>


            <div class="form-group">

                <label>Nama Barang</label>

                <input
                    type="text"
                    name="nama_barang"
                    value="{{ old('nama_barang') }}"
                    placeholder="Contoh: Obeng Plus"
                    required
                >

                @error('nama_barang')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>


            <div class="form-group">

                <label>Foto Barang</label>

                <input
                    type="file"
                    name="gambar"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <div class="help">
                    Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                </div>

                @error('gambar')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>


            <div class="form-group">

                <label>Kategori</label>

                <input
                    type="text"
                    name="kategori"
                    value="{{ old('kategori') }}"
                    placeholder="Contoh: Perkakas"
                    required
                >

                @error('kategori')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>


            <div class="form-group">

                <label>Stok</label>

                <input
                    type="number"
                    name="stok"
                    value="{{ old('stok', 0) }}"
                    min="0"
                    required
                >

                @error('stok')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>


            <div class="form-group">

                <label>Kondisi</label>

                <select name="kondisi" required>

                    <option value="">
                        -- Pilih Kondisi --
                    </option>

                    <option value="baik">
                        Baik
                    </option>

                    <option value="rusak_ringan">
                        Rusak Ringan
                    </option>

                    <option value="rusak_berat">
                        Rusak Berat
                    </option>

                </select>

                @error('kondisi')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>


            <div class="form-group">

                <label>Keterangan</label>

                <textarea
                    name="keterangan"
                    placeholder="Keterangan tambahan..."
                >{{ old('keterangan') }}</textarea>

            </div>


            <button type="submit" class="btn">
                + Simpan Barang
            </button>

        </form>

    </div>

</div>

</body>
</html>