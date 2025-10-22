<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    // Halaman utama E-Kuesioner
    public function index()
    {
        return view('welcome');
    }
}
