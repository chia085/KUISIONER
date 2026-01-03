<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\Kuisioner;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminLoginController extends Controller
{
    // ============================ LOGIN ============================

    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($request->username === 'admin' && $request->password === 'polibatam123') {
            Session::put('is_admin_logged_in', true);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['login' => 'Username atau password salah!']);
    }

    public function logout()
    {
        Session::forget('is_admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        if (!Session::get('is_admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.dashboard');
    }

    // ============================ ANALISIS ============================

    public function analisis(Request $request)
    {
        if (!Session::get('is_admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $dbRoles = Jawaban::select('role')
            ->whereNotNull('role')
            ->distinct()
            ->pluck('role');

        $roles = collect(['mahasiswa', 'dosen', 'alumni', 'pihak eksternal polibatam', 'masyarakat umum'])
            ->merge($dbRoles)
            ->unique()
            ->values();

        $kuisioners = Kuisioner::select('id', 'judul')->get();

        $selectedRole      = $request->get('role');
        $selectedKuisioner = $request->get('kuisioner_id');

        $query = Jawaban::query()
            ->leftJoin('pertanyaans', 'jawabans.pertanyaan_id', '=', 'pertanyaans.id')
            ->leftJoin('kuisioners', 'jawabans.kuisioner_id', '=', 'kuisioners.id')
            ->select(
                'jawabans.id',
                'jawabans.role',
                'jawabans.jawaban',
                'jawabans.created_at',
                'pertanyaans.pertanyaan as teks_pertanyaan',
                'kuisioners.judul as kuisioner_judul'
            );

        if ($selectedRole) {
            $query->where('jawabans.role', $selectedRole);
        }

        if ($selectedKuisioner) {
            $query->where('kuisioners.id', $selectedKuisioner);
        }

        $jawabans = $query->orderBy('jawabans.created_at', 'desc')->get();

        return view('admin.analisis', compact(
            'roles',
            'kuisioners',
            'jawabans',
            'selectedRole',
            'selectedKuisioner'
        ));
    }

    // ============================ GRAFIK MODEL B ============================

    public function grafik(Request $request)
    {
        if (!Session::get('is_admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Semua kuisioner aktif
        $kuisionerList = Kuisioner::where('status', 'aktif')
            ->orderBy('judul')
            ->get();

        if ($kuisionerList->isEmpty()) {
            return view('admin.grafik', [
                'kuisionerList'     => [],
                'selectedKuisioner' => null,
                'roleList'          => [],
                'selectedRole'      => null,
                'opsi'              => [],
                'pertanyaanData'    => [],
                'grandTotal'        => 0,
            ]);
        }

        $selectedKuisionerId = $request->query('kuisioner_id', $kuisionerList->first()->id);
        $selectedKuisioner   = Kuisioner::findOrFail($selectedKuisionerId);

        // Periode
        $startDate = $request->query('start_date', $selectedKuisioner->start_date);
        $endDate   = $request->query('end_date', $selectedKuisioner->end_date);

        // Role unik
        $roleList = Jawaban::where('kuisioner_id', $selectedKuisionerId)
            ->select('role')
            ->distinct()
            ->pluck('role')
            ->values()
            ->all();

        $selectedRole = $request->query('role');
        if ($selectedRole === 'semua' || $selectedRole === '') {
            $selectedRole = null;
        }

        $opsi = ['Sangat Baik', 'Baik', 'Cukup', 'Buruk', 'Sangat Buruk'];

        // Pertanyaan
        $pertanyaans = Pertanyaan::where('kuisioner_id', $selectedKuisionerId)
            ->orderBy('id')
            ->get();

        $pertanyaanData = [];
        $grandTotal = 0;

        foreach ($pertanyaans as $p) {

            // PILIHAN GANDA
            $query = Jawaban::where('kuisioner_id', $selectedKuisionerId)
                ->where('pertanyaan_id', $p->id)
                ->whereBetween('created_at', [$startDate, $endDate]);

            if ($selectedRole) {
                $query->where('role', $selectedRole);
            }

            $counts = $query
                ->select('jawaban', DB::raw('COUNT(*) as total'))
                ->groupBy('jawaban')
                ->pluck('total', 'jawaban');

            $rows = [];
            $chartData = [];
            $rowTotal = 0;

            foreach ($opsi as $o) {
                $val = (int)($counts[$o] ?? 0);
                $rows[] = ['label' => $o, 'jumlah' => $val];
                $chartData[] = $val;
                $rowTotal += $val;
            }

            $grandTotal += $rowTotal;

            // JAWABAN ISIAN
            $jawabanIsian = Jawaban::where('kuisioner_id', $selectedKuisionerId)
                ->where('pertanyaan_id', $p->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->when($selectedRole, fn($q) => $q->where('role', $selectedRole))
                ->whereNotIn('jawaban', $opsi)
                ->pluck('jawaban')
                ->toArray();

            $pertanyaanData[] = [
                'id'         => $p->id,
                'pertanyaan' => $p->pertanyaan,
                'chartLabels'=> $opsi,
                'chartData'  => $chartData,
                'rows'       => $rows,
                'total'      => $rowTotal,
                'isian'      => $jawabanIsian
            ];
        }

        return view('admin.grafik', [
            'kuisionerList'     => $kuisionerList,
            'selectedKuisioner' => $selectedKuisioner,
            'roleList'          => $roleList,
            'selectedRole'      => $selectedRole,
            'opsi'              => $opsi,
            'pertanyaanData'    => $pertanyaanData,
            'grandTotal'        => $grandTotal,
        ]);
    }

    // ============================ EXPORT EXCEL ============================

    public function exportGrafikExcel(Request $request)
    {
        if (!Session::get('is_admin_logged_in')) return redirect()->route('admin.login');

        $kuisionerId = $request->query('kuisioner_id');
        $role        = $request->query('role');
        $startDate   = $request->query('start_date');
        $endDate     = $request->query('end_date');

        $kuisioner = Kuisioner::findOrFail($kuisionerId);

        $opsi = ['Sangat Baik', 'Baik', 'Cukup', 'Buruk', 'Sangat Buruk'];

        $pertanyaans = Pertanyaan::where('kuisioner_id', $kuisionerId)->get();

        $jawaban = Jawaban::where('kuisioner_id', $kuisionerId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when($role && $role !== 'semua', fn($q) => $q->where('role', $role))
            ->select('pertanyaan_id', 'jawaban', DB::raw('COUNT(*) as total'))
            ->groupBy('pertanyaan_id', 'jawaban')
            ->get();

        $filename = 'grafik_kuisioner_' . $kuisionerId . '.csv';

        return new StreamedResponse(function () use ($kuisioner, $role, $opsi, $pertanyaans, $jawaban) {
            $out = fopen('php://output', 'w');

            fputcsv($out, ['Kuisioner', $kuisioner->judul]);
            fputcsv($out, ['Role', $role ?: 'Semua Role']);
            fputcsv($out, []);

            $header = array_merge(['Pertanyaan'], $opsi, ['Total']);
            fputcsv($out, $header);

            foreach ($pertanyaans as $p) {
                $row = [$p->pertanyaan];
                $total = 0;

                foreach ($opsi as $o) {
                    $match = $jawaban->first(fn($j) => $j->pertanyaan_id == $p->id && $j->jawaban == $o);
                    $val = $match ? $match->total : 0;
                    $row[] = $val;
                    $total += $val;
                }

                $row[] = $total;
                fputcsv($out, $row);
            }

            fclose($out);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"'
        ]);
    }

    // ============================ EXPORT PDF ============================

    public function exportGrafikPdf(Request $request)
    {
        if (!Session::get('is_admin_logged_in')) return redirect()->route('admin.login');

        $kuisionerId = $request->query('kuisioner_id');
        $role        = $request->query('role');
        $startDate   = $request->query('start_date');
        $endDate     = $request->query('end_date');

        $kuisioner = Kuisioner::findOrFail($kuisionerId);
        $opsi = ['Sangat Baik', 'Baik', 'Cukup', 'Buruk', 'Sangat Buruk'];

        $pertanyaans = Pertanyaan::where('kuisioner_id', $kuisionerId)->get();

        $jawaban = Jawaban::where('kuisioner_id', $kuisionerId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when($role && $role !== 'semua', fn($q) => $q->where('role', $role))
            ->get();

        $data = [
            'kuisioner'   => $kuisioner,
            'role'        => $role,
            'opsi'        => $opsi,
            'pertanyaans' => $pertanyaans,
            'jawaban'     => $jawaban,
            'start_date'  => $startDate,
            'end_date'    => $endDate,
        ];

        $pdf = Pdf::loadView('admin.grafik_pdf', $data)->setPaper('a4', 'landscape');
        return $pdf->download('grafik_kuisioner_'.$kuisionerId.'.pdf');
    }
}
