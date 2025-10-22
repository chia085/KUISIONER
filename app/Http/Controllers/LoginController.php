<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Halaman login utama
    public function index()
    {
        return view('login');
    }

    // Proses login (belum terhubung ke database)
    public function authenticate(Request $request)
    {
        // Untuk sementara hanya validasi input dasar
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Nanti di sini bisa ditambahkan autentikasi ke database
        return redirect()->route('dashboard')->with('success', 'Login berhasil (dummy)');
    }
}


