<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ajukan Peminjaman - TITL</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 8px;
            color: #1e3a8a;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
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
            padding: 11px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
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

        .barang-box {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background: #f9fafb;
        }

        .barang-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .barang-header h3 {
            margin: 0;
        }

        .stok-info {
            color: #2563eb;
            font-size: 14px;
            margin-top: 7px;
        }

        .button-area {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        button,
        .btn-kembali {
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-submit {
            background: #2563eb;
            color: white;
        }

        .btn-submit:hover {
            background: #1d4ed8;
        }

        .btn-kembali {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-kembali:hover {
            background: #d1d5db;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .required {
            color: red;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>Ajukan Peminjaman</h1>

        <p class="subtitle">
            Silakan isi data peminjaman alat TITL dengan benar.
        </p>

        {{-- Pesan error --}}
        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Terjadi kesalahan:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Pesan error dari controller --}}
        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('peminjaman.store') }}" method="POST">

            @csrf

            {{-- Tanggal Pinjam --}}
            <div class="form-group">

                <label for="tanggal_pinjam">
                    Tanggal Pinjam <span class="required">*</span>
                </label>

                <input
                    type="date"
                    id="tanggal_pinjam"
                    name="tanggal_pinjam"
                    value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                    required
                >

            </div>


            {{-- Tanggal Rencana Kembali --}}
            <div class="form-group">

                <label for="tanggal_rencana_kembali">
                    Rencana Tanggal Kembali
                    <span class="required">*</span>
                </label>

                <input
                    type="date"
                    id="tanggal_rencana_kembali"
                    name="tanggal_rencana_kembali"
                    value="{{ old('tanggal_rencana_kembali') }}"
                    required
                >

            </div>


            {{-- Barang --}}
            <div class="form-group">

                <label>
                    Pilih Barang <span class="required">*</span>
                </label>

                <div class="barang-box">

                    <div class="barang-header">
                        <h3>Barang yang Dipinjam</h3>
                    </div>

                    <label for="barang_id">
                        Nama Barang
                    </label>

                    <select
                        name="items[0][barang_id]"
                        id="barang_id"
                        required
                    >

                        <option value="">
                            -- Pilih Barang --
                        </option>

                        @foreach ($barangs as $barang)

                            <option
                                value="{{ $barang->id }}"
                                data-stok="{{ $barang->stok }}"
                                {{ old('items.0.barang_id') == $barang->id ? 'selected' : '' }}
                            >
                                {{ $barang->nama_barang }}
                                - Stok: {{ $barang->stok }}
                            </option>

                        @endforeach

                    </select>

                    <div class="stok-info" id="stokInfo">
                        Pilih barang untuk melihat stok.
                    </div>

                    <br>

                    <label for="jumlah">
                        Jumlah yang Dipinjam
                    </label>

                    <input
                        type="number"
                        name="items[0][jumlah]"
                        id="jumlah"
                        min="1"
                        value="{{ old('items.0.jumlah', 1) }}"
                        required
                    >

                </div>

            </div>


            {{-- Catatan --}}
            <div class="form-group">

                <label for="catatan">
                    Catatan
                </label>

                <textarea
                    name="catatan"
                    id="catatan"
                    placeholder="Contoh: Digunakan untuk praktik instalasi listrik..."
                >{{ old('catatan') }}</textarea>

            </div>


            {{-- Tombol --}}
            <div class="button-area">

                <a
                    href="{{ route('peminjaman.index') }}"
                    class="btn-kembali"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="btn-submit"
                >
                    Ajukan Peminjaman
                </button>

            </div>

        </form>

    </div>

</div>


<script>

    const barangSelect = document.getElementById('barang_id');
    const jumlahInput = document.getElementById('jumlah');
    const stokInfo = document.getElementById('stokInfo');

    function updateStok() {

        const option =
            barangSelect.options[barangSelect.selectedIndex];

        const stok =
            option.getAttribute('data-stok');

        if (stok) {

            stokInfo.textContent =
                'Stok tersedia: ' + stok;

            jumlahInput.max = stok;

            if (parseInt(jumlahInput.value) > parseInt(stok)) {
                jumlahInput.value = stok;
            }

        } else {

            stokInfo.textContent =
                'Pilih barang untuk melihat stok.';

            jumlahInput.removeAttribute('max');
        }
    }

    barangSelect.addEventListener(
        'change',
        updateStok
    );

    jumlahInput.addEventListener(
        'input',
        function () {

            const max =
                parseInt(jumlahInput.max);

            const value =
                parseInt(jumlahInput.value);

            if (max && value > max) {

                jumlahInput.value = max;

                alert(
                    'Jumlah tidak boleh melebihi stok barang.'
                );
            }
        }
    );

    updateStok();

</script>

</body>
</html>