<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login', [
            'title' => 'Login - E-Kuesioner Polibatam'
        ]);
    }

    // Proses login (belum terhubung ke database)
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // sementara hanya menampilkan data input
        return back()->with('success', "Login berhasil sebagai: {$username}");
    }
}


