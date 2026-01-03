<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ManajemenController extends Controller
{
    public function index()
    {
        return view('manajemen');
    }

    public function mahasiswa()
    {
        // Simulasi data layanan (sementara pakai array)
        $layanan = collect([
            (object)['id' => 1, 'nama' => 'Pelayanan Akademik'],
            (object)['id' => 2, 'nama' => 'Pelayanan Fasilitas Kampus'],
        ]);

        return view('manajemen.mahasiswa', compact('layanan'));
    }

    public function polibatam()
    {
        return view('manajemen.polibatam');
    }

    public function alumni()
    {
        return view('manajemen.alumni');
    }

    public function masyarakat()
    {
        return view('manajemen.masyarakat');
    }

    // Fungsi tambah layanan (sementara dummy)
    public function tambahLayanan(Request $request)
    {
        return back()->with('success', 'Layanan berhasil ditambahkan (simulasi).');
    }

    // Fungsi hapus layanan (sementara dummy)
    public function hapusLayanan($id)
    {
        return back()->with('success', 'Layanan berhasil dihapus (simulasi).');
    }
}



