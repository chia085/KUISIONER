<?php

namespace App\Http\Controllers;

use App\Models\Kuisioner;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use Illuminate\Http\Request;

class KuisionerController extends Controller
{
    private function roleOptions(): array
    {
        return [
            'mahasiswa' => 'Mahasiswa',
            'dosen' => 'Dosen',
            'tendik' => 'Tendik',
            'masyarakat umum' => 'Masyarakat Umum',
            'industri' => 'Industri',
            'staff' => 'Staff',
        ];
    }

public function show(Request $request, $id)
{
    $kuisioner = Kuisioner::findOrFail($id);

    $allowedRoles = $kuisioner->target_roles;
    $roleParam = $request->query('role');

    if (!$roleParam || !in_array($roleParam, $allowedRoles, true)) {
        return view('kuisioner.pilih_role', [
            'kuisioner' => $kuisioner,
            'allowedRoles' => $allowedRoles,
            'roleOptions' => $this->roleOptions()
        ]);
    }

    // ✅ FIX: ambil pertanyaan umum + pertanyaan khusus role yang dipilih saja
    $pertanyaans = Pertanyaan::where('kuisioner_id', $id)
        ->where(function ($q) use ($roleParam) {
            $q->whereNull('role')
              ->orWhere('role', $roleParam);
        })
        ->orderBy('id')
        ->get();

    return view('kuisioner.show', [
        'kuisioner' => $kuisioner,
        'pertanyaans' => $pertanyaans,
        'role' => $roleParam
    ]);
}


    public function submit(Request $request, $id)
    {
        $kuisioner = Kuisioner::findOrFail($id);

        $role = $request->role;

        foreach ($request->jawaban as $pid => $isi) {
            Jawaban::create([
                'kuisioner_id'  => $id,
                'pertanyaan_id' => $pid,
                'role'          => $role,
                'jawaban'       => $isi
            ]);
        }

        return redirect()->route('kuisioner.grafik', $id)
            ->with('sukses_kirim', true);
    }

    // ================================
    // GRAPH LAYANAN (FINAL FIXED)
    // ================================
    public function grafikLayanan($id)
    {
        $kuisioner = Kuisioner::findOrFail($id);

        $positif = ['Sangat Baik', 'Baik'];

        $totalResponden = Jawaban::where('kuisioner_id', $id)
            ->distinct('role')
            ->count('role');

        $pertanyaans = Pertanyaan::where('kuisioner_id', $id)->get();

        $totalJawaban = 0;
        $totalPositif = 0;

        foreach ($pertanyaans as $p) {

            $jumlah = Jawaban::where('pertanyaan_id', $p->id)->count();
            $totalJawaban += $jumlah;

            $jumlahPositif = Jawaban::where('pertanyaan_id', $p->id)
                ->whereIn('jawaban', ['Sangat Baik', 'Baik'])
                ->count();

            $totalPositif += $jumlahPositif;
        }

        $persen = $totalJawaban > 0
            ? round(($totalPositif / $totalJawaban) * 100, 1)
            : 0;

        return view('kuisioner.grafik_layanan', [
            'kuisioner'      => $kuisioner,
            'totalResponden' => $totalResponden,
            'total'          => $totalJawaban,
            'persen'         => $persen
        ]);
    }

    // ================================
    // GRAPH PER ROLE (RESPONDEN)
    // ================================
    public function grafikResponden($id, $role)
    {
        $kuisioner = Kuisioner::findOrFail($id);

        $opsi = ['Sangat Baik', 'Baik', 'Cukup', 'Buruk', 'Sangat Buruk'];

        $pertanyaans = Pertanyaan::where('kuisioner_id', $id)->orderBy('id')->get();

        $data = [];

        foreach ($pertanyaans as $p) {

            $counts = Jawaban::where('kuisioner_id', $id)
                ->where('pertanyaan_id', $p->id)
                ->where('role', $role)
                ->selectRaw('jawaban, COUNT(*) as total')
                ->groupBy('jawaban')
                ->pluck('total', 'jawaban');

            $chart = [];
            foreach ($opsi as $o) {
                $chart[] = $counts[$o] ?? 0;
            }

            $data[] = [
                'pertanyaan' => $p->pertanyaan,
                'chart'      => $chart,
                'opsi'       => $opsi
            ];
        }

        return view('kuisioner.grafik_responden', compact('kuisioner', 'role', 'data'));
    }
}
