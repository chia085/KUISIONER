<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kuisioner;
use App\Models\Jawaban;

// kalau kamu pakai dompdf
use Barryvdh\DomPDF\Facade\Pdf;

class AdminJawabanController extends Controller
{
    private function buildQuery(Request $request)
    {
        $selectedKuisioner = $request->query('kuisioner_id');
        $startDate         = $request->query('start_date');
        $endDate           = $request->query('end_date');
        $tipe              = $request->query('tipe', 'semua'); // semua | saran | pilihan

        // normalisasi kosong -> null
        $selectedKuisioner = ($selectedKuisioner === '' || $selectedKuisioner === null) ? null : $selectedKuisioner;
        $startDate         = ($startDate === '' || $startDate === null) ? null : $startDate;
        $endDate           = ($endDate === '' || $endDate === null) ? null : $endDate;

        $q = Jawaban::query()
            ->with(['kuisioner', 'pertanyaan'])
            ->orderBy('created_at', 'DESC');

        if ($selectedKuisioner) {
            $q->where('kuisioner_id', $selectedKuisioner);
        }

        if ($startDate) {
            $q->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $q->whereDate('created_at', '<=', $endDate);
        }

        // FILTER TIPE (sesuaikan kolom tipe pertanyaan kamu)
        if ($tipe === 'saran') {
            $q->whereHas('pertanyaan', function ($qq) {
                $qq->whereIn('tipe', ['saran', 'isian']);
            });
        } elseif ($tipe === 'pilihan') {
            $q->whereHas('pertanyaan', function ($qq) {
                $qq->whereIn('tipe', ['pilihan', 'pilihan_ganda', 'skala']);
            });
        }

        return [$q, $selectedKuisioner, $startDate, $endDate, $tipe];
    }

    public function index(Request $request)
    {
        $kuisioners = Kuisioner::orderBy('judul', 'ASC')->get();

        [$q, $selectedKuisioner, $startDate, $endDate, $tipe] = $this->buildQuery($request);

        $jawabans = $q->get();

        return view('admin.jawaban.index', compact(
            'jawabans',
            'kuisioners',
            'selectedKuisioner',
            'startDate',
            'endDate',
            'tipe'
        ));
    }

    public function exportPdf(Request $request)
    {
        [$q, $selectedKuisioner, $startDate, $endDate, $tipe] = $this->buildQuery($request);

        $jawabans = $q->get();

        $judulKuisioner = 'Semua Kuisioner';
        if ($selectedKuisioner) {
            $k = Kuisioner::find($selectedKuisioner);
            if ($k) $judulKuisioner = $k->judul;
        }

        // render ke pdf
        $pdf = Pdf::loadView('admin.jawaban.export_pdf', [
            'jawabans'       => $jawabans,
            'judulKuisioner' => $judulKuisioner,
            'startDate'      => $startDate,
            'endDate'        => $endDate,
            'tipe'           => $tipe,
        ])->setPaper('a4', 'landscape');

        $nama = 'jawaban_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->download($nama);
    }
}
