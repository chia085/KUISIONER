<?php

namespace App\Http\Controllers;

use App\Models\Kuisioner;
use App\Models\Jawaban;
use Illuminate\Http\Request;

class PolibatamController extends Controller
{
    public function index(Request $request)
    {
        // id kuisioner dari QR: /polibatam?kuisioner=21
        $selectedId = $request->query('kuisioner');

        // ===============================
        // KUISIONER PUBLIK (HANYA AKTIF)
        // ===============================
        $query = Kuisioner::where('status', 1) // 🔥 INI KUNCI UTAMA
            ->orderBy('judul');

        // Jika datang dari QR → tampilkan 1 kuisioner itu saja
        if ($selectedId) {
            $query->where('id', $selectedId);
        }

        $kuisioners = $query->get();

        // ===============================
        // DATA GRAFIK PUBLIK (HANYA AKTIF)
        // ===============================
        $grafikData = $this->getGrafikDataPublik();

        return view('polibatam', compact(
            'kuisioners',
            'grafikData',
            'selectedId'
        ));
    }

    // ===============================
    // HALAMAN GRAFIK PUBLIK
    // ===============================
    public function grafikPublik()
    {
        $grafikData = $this->getGrafikDataPublik();
        return view('polibatam_grafik', compact('grafikData'));
    }

    // ===============================
    // LOGIKA GRAFIK (HANYA KUISIONER AKTIF)
    // ===============================
    private function getGrafikDataPublik()
    {
        $kuisioners = Kuisioner::where('status', 1) // 🔥 WAJIB
            ->orderBy('judul')
            ->get();

        $opsiPositif = ['Sangat Baik', 'Baik'];
        $data = [];

        foreach ($kuisioners as $k) {
            $total = Jawaban::where('kuisioner_id', $k->id)->count();

            $positif = Jawaban::where('kuisioner_id', $k->id)
                ->whereIn('jawaban', $opsiPositif)
                ->count();

            $persen = $total > 0
                ? round(($positif / $total) * 100, 1)
                : 0;

            $data[] = [
                'judul'  => $k->judul,
                'total'  => $total,
                'persen' => $persen,
            ];
        }

        return $data;
    }
}
