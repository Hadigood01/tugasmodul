<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN PENGGUNA
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN ADMIN
    |--------------------------------------------------------------------------
    */

    public function showAdminLogin()
{
    return view('auth.admin-login');
}

    public function loginAdmin(Request $request)
    {
        $data = $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $field = filter_var(
            $data['login'],
            FILTER_VALIDATE_EMAIL
        )
            ? 'email'
            : 'username';

        if (
            Auth::attempt([
                $field => $data['login'],
                'password' => $data['password'],
                'role' => 'admin',
            ])
        ) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withErrors([
                'login' => 'Akun admin tidak ditemukan atau password salah.',
            ])
            ->onlyInput('login');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:100',

            'username' => 'required|max:50|unique:users,username',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],

            'username' => $data['username'],

            'email' => $data['email'],

            'password' => Hash::make($data['password']),

            'role' => 'pengguna',
        ]);

        Auth::login($user);

        return redirect()
            ->route('pengguna.dashboard')
            ->with(
                'success',
                'Registrasi berhasil.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES LOGIN PENGGUNA
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => 'required',

            'password' => 'required',
        ]);

        $field = filter_var(
            $data['login'],
            FILTER_VALIDATE_EMAIL
        )
            ? 'email'
            : 'username';

        if (
            Auth::attempt([
                $field => $data['login'],

                'password' => $data['password'],
            ])
        ) {
            $request->session()->regenerate();

            $user = Auth::user();

            /*
            |--------------------------------------------------------------------------
            | ADMIN
            |--------------------------------------------------------------------------
            */

            if ($user->role === 'admin') {
                return redirect()
                    ->route('admin.dashboard');
            }

            /*
            |--------------------------------------------------------------------------
            | PENGGUNA
            |--------------------------------------------------------------------------
            */

            if ($user->role === 'pengguna') {
                return redirect()
                    ->route('pengguna.dashboard');
            }

            /*
            |--------------------------------------------------------------------------
            | ROLE TIDAK DIKENAL
            |--------------------------------------------------------------------------
            */

            Auth::logout();

            return back()
                ->withErrors([
                    'login' => 'Role akun tidak valid.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN GAGAL
        |--------------------------------------------------------------------------
        */

        return back()
            ->withErrors([
                'login' => 'Username/email atau password salah.',
            ])
            ->onlyInput('login');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login');
    }
}