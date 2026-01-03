<?php

namespace App\Http\Controllers;

use App\Models\Kuisioner;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    /** daftar role global */
    private function roleOptions(): array
    {
        return [
            'mahasiswa'         => 'Mahasiswa',
            'dosen'             => 'Dosen',
            'tendik'            => 'Tendik',
            'ka unit'           => 'Ka Unit',
            'masyarakat umum'   => 'Masyarakat Umum',
            'auditor internal'  => 'Auditor Internal',
            'mitra pkm'         => 'Mitra PKM',
            'pelaksana pkm'     => 'Pelaksana PKM',
            'mitra kerjasama'   => 'Mitra Kerjasama',
            'sbkk'              => 'SBKK',
            'sbum'              => 'SBUM',
            'p3m'               => 'P3M',
            'industri'          => 'Industri',
            'staff'             => 'Staff',
            'laboran'           => 'Laboran',
            'manajer proyek'    => 'Manajer Proyek',
            'calon mahasiswa'   => 'Calon Mahasiswa',
            'lulusan'           => 'Lulusan',
            'tamu'              => 'Tamu',
            'pihak eksternal'   => 'Pihak Eksternal',
            'mitra penelitian'  => 'Mitra Penelitian',
        ];
    }

    // ============================================================
    // INDEX – Dropdown kuisioner + list pertanyaan
    // ============================================================
    public function index(Request $request)
    {
        $kuisioners = Kuisioner::orderBy('judul')->get();
        $selected = $request->query('kuisioner_id');

        $pertanyaan = collect();
        if ($selected) {
            $pertanyaan = Pertanyaan::where('kuisioner_id', $selected)
                ->orderBy('id')
                ->get();
        }

        return view('admin.pertanyaan.index', compact('kuisioners', 'pertanyaan', 'selected'));
    }

    // ============================================================
    public function create(Request $request)
    {
        $kuisioners = Kuisioner::orderBy('judul')->get();
        $roleOptions = $this->roleOptions();

        $selectedKuisionerId = $request->query('kuisioner_id');
        $allowedRoles = [];

        if ($selectedKuisionerId) {
            $k = Kuisioner::find($selectedKuisionerId);
            if ($k) {
                $allowedRoles = $k->target_roles;
            }
        }

        return view('admin.pertanyaan.create', compact(
            'kuisioners',
            'roleOptions',
            'allowedRoles',
            'selectedKuisionerId'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kuisioner_id' => 'required|exists:kuisioners,id',
            'roles'        => 'required|array',
            'roles.*'      => 'string',
            'pertanyaan'   => 'required|array',
            'pertanyaan.*' => 'required|string',
            'tipe'         => 'required|in:pilihan_ganda,isian',
        ]);

        foreach ($request->roles as $role) {
            foreach ($request->pertanyaan as $text) {
                Pertanyaan::create([
                    'kuisioner_id' => $request->kuisioner_id,
                    'role'         => $role,
                    'pertanyaan'   => $text,
                    'tipe'         => $request->tipe,
                ]);
            }
        }

        return redirect()->route('admin.pertanyaan.index', ['kuisioner_id' => $request->kuisioner_id])
            ->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    public function edit(Pertanyaan $pertanyaan)
    {
        return view('admin.pertanyaan.edit', compact('pertanyaan'));
    }

    // ============================================================
    // UPDATE (VERSI FIX) – TANPA ROLE & TANPA KUISIONER_ID
    // ============================================================
    public function update(Request $request, Pertanyaan $pertanyaan)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'tipe'       => 'required|in:pilihan_ganda,isian',
        ]);

        $pertanyaan->update([
            'pertanyaan' => $request->pertanyaan,
            'tipe'       => $request->tipe,
        ]);

        return redirect()->route('admin.pertanyaan.index', ['kuisioner_id' => $pertanyaan->kuisioner_id])
            ->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    public function destroy(Pertanyaan $pertanyaan)
    {
        $id = $pertanyaan->kuisioner_id;
        $pertanyaan->delete();

        return redirect()->route('admin.pertanyaan.index', ['kuisioner_id' => $id])
            ->with('success', 'Pertanyaan berhasil dihapus!');
    }
}
