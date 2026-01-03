<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Kuisioner;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class JawabanController extends Controller
{
    private function normalizeDate(?string $d): ?string
    {
        if (!$d) return null;

        // sudah YYYY-MM-DD
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $d)) {
            return $d;
        }

        // handle DD/MM/YYYY
        try {
            return Carbon::createFromFormat('d/m/Y', $d)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function index(Request $request)
    {
        $kuisioners = Kuisioner::orderBy('judul')->get();

        $selectedKuisioner = $request->get('kuisioner_id', 'semua');
        $tipe      = $request->get('tipe', 'semua'); // semua | pilihan | saran
        $startDate = $this->normalizeDate($request->get('start_date'));
        $endDate   = $this->normalizeDate($request->get('end_date'));

        $opsiPilihan = ['Sangat Baik', 'Baik', 'Cukup', 'Buruk', 'Sangat Buruk'];

        $q = Jawaban::with(['kuisioner', 'pertanyaan'])
            ->orderBy('created_at', 'desc');

        // filter kuisioner
        if ($selectedKuisioner !== 'semua' && $selectedKuisioner !== '') {
            $q->where('kuisioner_id', $selectedKuisioner);
        }

        // filter tanggal (AMAN)
        if ($startDate) {
            $q->where('created_at', '>=', $startDate . ' 00:00:00');
        }

        if ($endDate) {
            $q->where('created_at', '<=', $endDate . ' 23:59:59');
        }

        // filter tipe jawaban (INI YANG BIKIN SARAN SEKARANG MUNCUL)
        if ($tipe === 'pilihan') {
            $q->whereIn('jawaban', $opsiPilihan);
        } elseif ($tipe === 'saran') {
            $q->where(function ($qq) use ($opsiPilihan) {
                $qq->whereNotIn('jawaban', $opsiPilihan)
                   ->whereNotNull('jawaban')
                   ->where('jawaban', '!=', '');
            });
        }

        $jawabans = $q->paginate(25)->appends($request->query());

        return view('admin.jawaban.index', compact(
            'jawabans',
            'kuisioners',
            'selectedKuisioner',
            'tipe',
            'startDate',
            'endDate'
        ));
    }

    public function exportPdf(Request $request)
    {
        $selectedKuisioner = $request->get('kuisioner_id', 'semua');
        $tipe      = $request->get('tipe', 'semua');
        $startDate = $this->normalizeDate($request->get('start_date'));
        $endDate   = $this->normalizeDate($request->get('end_date'));

        $opsiPilihan = ['Sangat Baik', 'Baik', 'Cukup', 'Buruk', 'Sangat Buruk'];

        $q = Jawaban::with(['kuisioner', 'pertanyaan'])
            ->orderBy('created_at', 'desc');

        if ($selectedKuisioner !== 'semua' && $selectedKuisioner !== '') {
            $q->where('kuisioner_id', $selectedKuisioner);
        }

        if ($startDate) {
            $q->where('created_at', '>=', $startDate . ' 00:00:00');
        }

        if ($endDate) {
            $q->where('created_at', '<=', $endDate . ' 23:59:59');
        }

        if ($tipe === 'pilihan') {
            $q->whereIn('jawaban', $opsiPilihan);
        } elseif ($tipe === 'saran') {
            $q->where(function ($qq) use ($opsiPilihan) {
                $qq->whereNotIn('jawaban', $opsiPilihan)
                   ->whereNotNull('jawaban')
                   ->where('jawaban', '!=', '');
            });
        }

        $jawabans = $q->get();

        $pdf = Pdf::loadView('admin.jawaban.pdf', compact(
            'jawabans',
            'selectedKuisioner',
            'tipe',
            'startDate',
            'endDate'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('jawaban_responden.pdf');
    }
}
