<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login TITL</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            font-family: Arial, sans-serif;

            background: #e0e7ff;

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;
        }

        .box {
            width: 420px;

            background: white;

            padding: 35px;

            border-radius: 16px;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, .15);
        }

        h1 {
            margin-top: 0;

            margin-bottom: 10px;
        }

        .subtitle {
            color: #555;

            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;

            margin-bottom: 7px;

            font-weight: bold;
        }

        input {
            width: 100%;

            padding: 12px;

            border: 1px solid #aaa;

            border-radius: 7px;

            font-size: 15px;
        }

        input:focus {
            outline: none;

            border-color: #2563eb;
        }

        .login-button {
            width: 100%;

            padding: 13px;

            background: #2563eb;

            color: white;

            border: none;

            border-radius: 7px;

            font-size: 15px;

            font-weight: bold;

            cursor: pointer;
        }

        .login-button:hover {
            background: #1d4ed8;
        }

        .admin-button {
            display: block;

            width: 100%;

            padding: 13px;

            background: #dc2626;

            color: white;

            text-align: center;

            text-decoration: none;

            border-radius: 7px;

            font-size: 15px;

            font-weight: bold;

            margin-top: 15px;
        }

        .admin-button:hover {
            background: #b91c1c;
        }

        .register {
            text-align: center;

            margin-top: 20px;

            color: #555;
        }

        .register a {
            color: #2563eb;

            text-decoration: none;

            font-weight: bold;
        }

        .register a:hover {
            text-decoration: underline;
        }

        .divider {
            display: flex;

            align-items: center;

            gap: 10px;

            margin: 25px 0;

            color: #999;

            font-size: 13px;
        }

        .divider::before,
        .divider::after {
            content: "";

            flex: 1;

            height: 1px;

            background: #ddd;
        }

        .error {
            background: #fee2e2;

            color: #991b1b;

            padding: 12px;

            border-radius: 7px;

            margin-bottom: 20px;

            font-size: 14px;
        }

        .success {
            background: #dcfce7;

            color: #166534;

            padding: 12px;

            border-radius: 7px;

            margin-bottom: 20px;

            font-size: 14px;
        }

        .footer {
            text-align: center;

            margin-top: 25px;

            font-size: 12px;

            color: #888;
        }

    </style>

</head>


<body>


<div class="box">

    <h1>
        Login
    </h1>

    <p class="subtitle">
        Sistem Peminjaman Barang TITL
    </p>


    {{-- PESAN ERROR --}}

    @if($errors->any())

        <div class="error">

            {{ $errors->first() }}

        </div>

    @endif


    {{-- PESAN SUCCESS --}}

    @if(session('success'))

        <div class="success">

            {{ session('success') }}

        </div>

    @endif


    {{-- LOGIN PENGGUNA --}}

    <form
        method="POST"
        action="{{ route('login.process') }}"
    >

        @csrf


        <div class="form-group">

            <label>
                Email / Username
            </label>

            <input
                type="text"
                name="login"
                value="{{ old('login') }}"
                placeholder="Masukkan email atau username"
                autocomplete="username"
                required
            >

        </div>


        <div class="form-group">

            <label>
                Password
            </label>

            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                autocomplete="current-password"
                required
            >

        </div>


        <button
            type="submit"
            class="login-button"
        >
            Login sebagai Pengguna
        </button>

    </form>


    {{-- PEMBATAS --}}

    <div class="divider">
        atau
    </div>


    {{-- LOGIN ADMIN --}}

    <a
        href="{{ route('admin.login') }}"
        class="admin-button"
    >
        🔐 Login sebagai Admin
    </a>


    {{-- REGISTER --}}

    <p class="register">

        Belum mempunyai akun?

        <a
            href="{{ route('register') }}"
        >
            Register
        </a>

    </p>


    <div class="footer">

        Sistem Peminjaman Barang
        <strong>TITL</strong>

    </div>


</div>


</body>

</html>