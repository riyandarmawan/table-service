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

        if(Auth::attempt($credentials)) {
            return redirect('/')->with('success', 'Anda berhasil login sebagai @' . $credentials['username']);
        }

        return back()->withErrors(['password' => 'Password yang anda masukkan salah!'])->onlyInput('username');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/auth/login')->with('success', 'Anda berhasil logout');
    }
}
