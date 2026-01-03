<?php

namespace App\Http\Controllers;

use App\Models\Kuisioner;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminGrafikController extends Controller
{
    private array $opsiPositif = ['Sangat Baik', 'Baik'];

    private function applyDateFilter($query, ?string $startDate, ?string $endDate)
    {
        // Filter berdasarkan created_at (tanggal submit jawaban)
        // NOTE: startDate/endDate harus format YYYY-MM-DD (dari input type="date")
        if (!empty($startDate)) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if (!empty($endDate)) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        return $query;
    }

    private function getGrafikData(?string $startDate = null, ?string $endDate = null): array
    {
        $kuisioners = Kuisioner::orderBy('judul')->get();
        $data = [];

        foreach ($kuisioners as $k) {
            $q = Jawaban::where('kuisioner_id', $k->id);
            $this->applyDateFilter($q, $startDate, $endDate);

            $total   = (clone $q)->count();
            $positif = (clone $q)->whereIn('jawaban', $this->opsiPositif)->count();
            $persen  = $total > 0 ? round(($positif / $total) * 100, 1) : 0;

            $data[] = [
                'judul'  => $k->judul,
                'total'  => $total,
                'persen' => $persen,
            ];
        }

        return $data;
    }

    // =========================
    // INDEX (GRAFIK KESELURUHAN)
    // =========================
    public function index(Request $request)
    {
        $startDate = $request->query('start_date', '');
        $endDate   = $request->query('end_date', '');

        // INI YANG DIPERBAIKI:
        // blade kamu butuh variabel $data (bukan $rows)
        $data = $this->getGrafikData($startDate, $endDate);

        return view('admin.grafik.index', compact(
            'data',
            'startDate',
            'endDate'
        ));
    }

    public function pilihLayanan()
    {
        $kuisioners = Kuisioner::orderBy('judul')->get();
        return view('admin.grafik.pilih', compact('kuisioners'));
    }

    public function layanan($id, Request $request)
    {
        $kuisioner = Kuisioner::findOrFail($id);

        $startDate = $request->query('start_date');
        $endDate   = $request->query('end_date');

        // list role untuk dropdown
        $roles = Jawaban::where('kuisioner_id', $id)
            ->select('role')->distinct()->pluck('role')->toArray();

        $selectedRole = $request->query('role', 'semua');

        $q = Jawaban::where('kuisioner_id', $id);

        if ($selectedRole !== 'semua') {
            $q->where('role', $selectedRole);
        }

        $this->applyDateFilter($q, $startDate, $endDate);

        $total   = (clone $q)->count();
        $positif = (clone $q)->whereIn('jawaban', $this->opsiPositif)->count();
        $persen  = $total > 0 ? round(($positif / $total) * 100, 1) : 0;

        return view('admin.grafik.layanan', compact(
            'kuisioner', 'roles', 'selectedRole', 'total', 'persen', 'startDate', 'endDate'
        ));
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate   = $request->query('end_date');

        $data = $this->getGrafikData($startDate, $endDate);

        return response()->streamDownload(function () use ($data) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Layanan', 'Total Responden', 'Persentase']);

            foreach ($data as $d) {
                fputcsv($out, [$d['judul'], $d['total'], $d['persen']]);
            }
            fclose($out);
        }, "grafik_keseluruhan.csv");
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate   = $request->query('end_date');

        $data = $this->getGrafikData($startDate, $endDate);

        $pdf = Pdf::loadView('admin.grafik_pdf_keseluruhan', compact('data', 'startDate', 'endDate'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("grafik_keseluruhan.pdf");
    }
}
