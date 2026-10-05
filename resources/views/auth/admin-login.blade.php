<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login Admin - TITL</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            font-family: Arial, sans-serif;

            background: #e8eefc;

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;
        }

        .login-box {
            width: 460px;

            background: white;

            padding: 35px;

            border-radius: 18px;

            box-shadow: 0 10px 30px rgba(0,0,0,.12);
        }

        h1 {
            margin-bottom: 10px;
        }

        .subtitle {
            margin-bottom: 25px;

            color: #555;
        }

        label {
            display: block;

            margin-bottom: 8px;

            font-weight: bold;
        }

        input {
            width: 100%;

            padding: 13px;

            margin-bottom: 18px;

            border: 1px solid #bbb;

            border-radius: 7px;

            font-size: 15px;
        }

        button {
            width: 100%;

            padding: 13px;

            border: none;

            border-radius: 7px;

            background: #dc2626;

            color: white;

            font-size: 16px;

            cursor: pointer;
        }

        button:hover {
            background: #b91c1c;
        }

        .back {
            display: block;

            text-align: center;

            margin-top: 20px;

            color: #2563eb;

            text-decoration: none;
        }

        .error {
            background: #fee2e2;

            color: #991b1b;

            padding: 12px;

            border-radius: 7px;

            margin-bottom: 20px;
        }

    </style>

</head>

<body>

<div class="login-box">

    <h1>🔐 Login Admin</h1>

    <p class="subtitle">
        Sistem Peminjaman Barang TITL
    </p>


    @if($errors->any())

        <div class="error">

            {{ $errors->first() }}

        </div>

    @endif


    <form
    action="{{ route('admin.login.process') }}"
    method="POST"
    >

        @csrf


        <label>
            Username / Email Admin
        </label>

        <input
            type="text"
            name="login"
            placeholder="Masukkan username admin"
            required
        >


        <label>
            Password
        </label>

        <input
            type="password"
            name="password"
            placeholder="Masukkan password admin"
            required
        >


        <button type="submit">
            Login sebagai Admin
        </button>

    </form>


    <a
        href="{{ route('login') }}"
        class="back"
    >
        ← Login sebagai Pengguna
    </a>

</div>

</body>

</html>