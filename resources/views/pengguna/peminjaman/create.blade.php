<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Ajukan Peminjaman - TITL</title>

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

        .container {
            max-width: 850px;
            margin: 40px auto;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,.08);
        }

        h1 {
            color: #1e3a8a;
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
        }

        textarea {
            min-height: 100px;
        }

        .barang-box {
            background: #f8fafc;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .stok {
            color: #16a34a;
            font-weight: bold;
            margin-top: 8px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .button-area {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-back {
            background: #64748b;
            color: white;
        }

        .btn-submit {
            background: #2563eb;
            color: white;
        }

        .btn-submit:hover {
            background: #1d4ed8;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="card">

        <h1>Ajukan Peminjaman</h1>

        <p>
            Silakan isi data peminjaman alat TITL.
        </p>


        @if($errors->any())

            <div class="error">

                <strong>Terjadi kesalahan:</strong>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        @if(session('error'))

            <div class="error">
                {{ session('error') }}
            </div>

        @endif


        <form
            action="{{ route('pengguna.peminjaman.store') }}"
            method="POST"
        >

            @csrf


            <div class="form-group">

                <label>
                    Tanggal Pinjam
                </label>

                <input
                    type="date"
                    name="tanggal_pinjam"
                    value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Rencana Tanggal Kembali
                </label>

                <input
                    type="date"
                    name="tanggal_rencana_kembali"
                    value="{{ old('tanggal_rencana_kembali') }}"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Pilih Barang
                </label>

                <div class="barang-box">

                    <select
                        name="items[0][barang_id]"
                        id="barang"
                        required
                    >

                        <option value="">
                            -- Pilih Barang --
                        </option>

                        @foreach($barangs as $barang)

                            <option
                                value="{{ $barang->id }}"
                                data-stok="{{ $barang->stok }}"
                            >

                                {{ $barang->kode_barang }}
                                -
                                {{ $barang->nama_barang }}

                                (Stok: {{ $barang->stok }})

                            </option>

                        @endforeach

                    </select>


                    <div
                        id="stokInfo"
                        class="stok"
                    >
                        Pilih barang untuk melihat stok.
                    </div>

                </div>

            </div>


            <div class="form-group">

                <label>
                    Jumlah yang Dipinjam
                </label>

                <input
                    type="number"
                    name="items[0][jumlah]"
                    id="jumlah"
                    min="1"
                    value="1"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Catatan
                </label>

                <textarea
                    name="catatan"
                    placeholder="Catatan peminjaman (opsional)"
                >{{ old('catatan') }}</textarea>

            </div>


            <div class="button-area">

                <a
                    href="{{ route('pengguna.barang') }}"
                    class="btn btn-back"
                >
                    ← Kembali
                </a>


                <button
                    type="submit"
                    class="btn btn-submit"
                >
                    Ajukan Peminjaman
                </button>

            </div>

        </form>

    </div>

</div>


<script>

const barang = document.getElementById('barang');

const jumlah = document.getElementById('jumlah');

const stokInfo = document.getElementById('stokInfo');


barang.addEventListener('change', function () {

    const option =
        barang.options[barang.selectedIndex];

    const stok =
        option.getAttribute('data-stok');

    if (stok) {

        stokInfo.innerText =
            'Stok tersedia: ' + stok;

        jumlah.max = stok;

    } else {

        stokInfo.innerText =
            'Pilih barang untuk melihat stok.';

        jumlah.removeAttribute('max');
    }

});


jumlah.addEventListener('input', function () {

    const max =
        parseInt(jumlah.max);

    if (
        max &&
        parseInt(jumlah.value) > max
    ) {
        jumlah.value = max;
    }

});

</script>

</body>

</html>