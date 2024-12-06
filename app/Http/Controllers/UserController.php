<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        $data = [
            'title' => 'Login',
        ];

        return view('pages.auth.login', $data);
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|exists:App\Models\User,username',
            'password' => 'required',
        ], [
            // username
            'username.required' => 'Username harus diisi!',
            'username.exists' => 'Username tidak ditemukan!',

            // password
            'password.required' => 'Password harus diisi!',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            switch ($user->role) {
                case 'administrator':
                    return redirect()->intended('/meja')->with('success', 'Anda berhasil masuk sebagai Administrator');
                case 'waiter':
                    return redirect()->intended('/pesanan')->with('success', 'Anda berhasil masuk sebagai Waiter');
                case 'kasir':
                    return redirect()->intended('/transaksi')->with('success', 'Anda berhasil masuk sebagai Cashier');
                case 'owner':
                    return redirect()->intended('/')->with('success', 'Anda berhasil masuk sebagai Owner');
                default:
                    Auth::logout(); // Log out if role is unrecognized
                    return redirect('/auth/login')->with('error', 'Role tidak dikenali. Hubungi Administrator.');
            }
        }

        return back()->withErrors(['password' => 'Password yang anda masukkan salah!'])->onlyInput('username');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/auth/login')->with('success', 'Anda berhasil keluar');
    }
}
