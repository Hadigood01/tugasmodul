<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Register TITL</title>

    <style>

        body {
            margin: 0;
            font-family: Arial;
            background: #e0e7ff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            width: 420px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow:
                0 10px 30px rgba(0,0,0,.15);
        }

        input {
            width: 100%;
            padding: 11px;
            margin:
                6px 0 14px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            background: #2563eb;
            color: white;
            border-radius: 7px;
        }

        a {
            color: #2563eb;
        }

    </style>

</head>

<body>

<div class="box">

    <h1>
        Register
    </h1>

    @if($errors->any())

        <div style="color:red">

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('register.process') }}"
    >

        @csrf


        <label>
            Nama
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            required
        >


        <label>
            Username
        </label>

        <input
            type="text"
            name="username"
            value="{{ old('username') }}"
            required
        >


        <label>
            Email
        </label>

        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
        >


        <label>
            Password
        </label>

        <input
            type="password"
            name="password"
            required
        >


        <label>
            Konfirmasi Password
        </label>

        <input
            type="password"
            name="password_confirmation"
            required
        >


        <button>
            Register
        </button>

    </form>


    <p>

        Sudah mempunyai akun?

        <a href="{{ route('login') }}">
            Login
        </a>

    </p>

</div>

</body>

</html>