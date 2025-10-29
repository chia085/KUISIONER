<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TentangController extends Controller
{
    public function index()
    {
        // Menampilkan halaman tentang
        return view('tentang');
    }
}
