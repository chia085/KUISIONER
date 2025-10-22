<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AkunController extends Controller
{
    // Halaman utama Kelola Akun Kepala Unit
    public function index()
    {
        // Dummy data sementara (nanti bisa diganti dari database)
        $akun = [
            ['nama' => 'Budi Santoso', 'username' => 'budi_s', 'email' => 'budi@polibatam.ac.id', 'status' => 'Aktif'],
            ['nama' => 'Siti Rahma', 'username' => 'siti_r', 'email' => 'siti@polibatam.ac.id', 'status' => 'Aktif'],
            ['nama' => 'Andi Pratama', 'username' => 'andi_p', 'email' => 'andi@polibatam.ac.id', 'status' => 'Tidak Aktif'],
            ['nama' => 'Dewi Lestari', 'username' => 'dewi_l', 'email' => 'dewi@polibatam.ac.id', 'status' => 'Aktif'],
            ['nama' => 'Rudi Hartono', 'username' => 'rudi_h', 'email' => 'rudi@polibatam.ac.id', 'status' => 'Aktif'],
            ['nama' => 'Eka Saputra', 'username' => 'eka_s', 'email' => 'eka@polibatam.ac.id', 'status' => 'Tidak Aktif'],
            ['nama' => 'Rina Kurnia', 'username' => 'rina_k', 'email' => 'rina@polibatam.ac.id', 'status' => 'Aktif'],
            ['nama' => 'Joko Mulyono', 'username' => 'joko_m', 'email' => 'joko@polibatam.ac.id', 'status' => 'Aktif'],
            ['nama' => 'Lina Susanti', 'username' => 'lina_s', 'email' => 'lina@polibatam.ac.id', 'status' => 'Aktif'],
            ['nama' => 'Fajar Nugroho', 'username' => 'fajar_n', 'email' => 'fajar@polibatam.ac.id', 'status' => 'Aktif'],
        ];

        // kirim data ke view
        return view('akun', compact('akun'));
    }
}
