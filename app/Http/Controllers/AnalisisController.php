<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalisisController extends Controller
{
    public function polibatam()
    {
        $data = [
            ['pertanyaan' => 'Kemudahan akses fasilitas kegiatan kemahasiswaan (keadaan dan non akademik)', 'responden' => 11],
            ['pertanyaan' => 'Sosialisasi informasi daftar ulang, beasiswa, peraturan', 'responden' => 11],
            ['pertanyaan' => 'Layanan administrasi kemahasiswaan terkait daftar ulang, beasiswa, peraturan surat, surat-menyurat', 'responden' => 11],
            ['pertanyaan' => 'Layanan administrasi kemahasiswaan responsif', 'responden' => 11],
        ];
        return view('analisis', ['data' => $data, 'kategori' => 'Polibatam']);
    }

    public function mahasiswa()
    {
        $data = [
            ['pertanyaan' => 'Kualitas layanan akademik bagi mahasiswa', 'responden' => 25],
            ['pertanyaan' => 'Ketersediaan sarana dan prasarana pembelajaran', 'responden' => 25],
        ];
        return view('analisis', ['data' => $data, 'kategori' => 'Mahasiswa']);
    }

    public function alumni()
    {
        $data = [
            ['pertanyaan' => 'Relevansi kurikulum dengan dunia kerja', 'responden' => 18],
            ['pertanyaan' => 'Ketersediaan jejaring alumni', 'responden' => 18],
        ];
        return view('analisis', ['data' => $data, 'kategori' => 'Alumni']);
    }

    public function masyarakat()
    {
        $data = [
            ['pertanyaan' => 'Kemudahan akses layanan masyarakat umum', 'responden' => 10],
            ['pertanyaan' => 'Pelayanan administrasi cepat dan tepat', 'responden' => 10],
        ];
        return view('analisis', ['data' => $data, 'kategori' => 'Masyarakat Umum']);
    }
}


