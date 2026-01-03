<?php

namespace App\Http\Controllers;

use App\Models\Kuisioner;
use Illuminate\Http\Request;

class AdminKuisionerController extends Controller
{
    // ================================
    // ROLE OPTIONS (dipakai create & edit)
    // ================================
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

    // ================================
    // INDEX
    // ================================
    public function index()
    {
        $kuisioners = Kuisioner::orderBy('judul', 'ASC')->get();
        return view('admin.kuisioner.index', compact('kuisioners'));
    }

    // ================================
    // CREATE VIEW
    // ================================
    public function create()
    {
        $roleOptions = $this->roleOptions();
        return view('admin.kuisioner.create', compact('roleOptions'));
    }

    // ================================
    // STORE (WITH DUPLICATE TITLE CHECK)
    // ================================
    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255|unique:kuisioners,judul',
            'deskripsi'   => 'nullable|string',
            'target_user' => 'required|array',
        ], [
            'judul.unique'         => 'Nama layanan / judul kuisioner ini sudah pernah dibuat.',
            'target_user.required' => 'Pilih minimal satu target responden.',
        ]);

        Kuisioner::create([
            'judul'       => $request->judul,
            'deskripsi'   => $request->deskripsi,
            'status'      => 1, // ✅ AKTIF = 1 (JANGAN STRING)
            'target_user' => json_encode($request->target_user),
        ]);

        return redirect()->route('admin.kuisioner.index')
            ->with('success', 'Kuisioner berhasil dibuat!');
    }

    // ================================
    // BUAT URL PUBLIK UNTUK KUISIONER
    // ================================
    protected function makeKuisionerPublicUrl(Kuisioner $kuisioner): string
    {
        $scheme = request()->getScheme();
        $host   = request()->getHost();
        $port   = request()->getPort();

        if (in_array($host, ['127.0.0.1', 'localhost', '0.0.0.0'])) {
            $host = getHostByName(getHostName());
        }

        $base = $scheme . '://' . $host;

        if (!in_array($port, [80, 443])) {
            $base .= ':' . $port;
        }

        $path = route('kuisioner.show', ['id' => $kuisioner->id], false);

        return $base . $path;
    }

    // ===========================
    // HALAMAN QR KUISIONER
    // ===========================
    public function qr($id)
    {
        $kuisioner = Kuisioner::findOrFail($id);

        $targetUrl = $this->makeKuisionerPublicUrl($kuisioner);

        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=400x400&margin=10&data='
            . urlencode($targetUrl);

        return view('admin.kuisioner.qr', [
            'kuisioner' => $kuisioner,
            'targetUrl' => $targetUrl,
            'qrUrl'     => $qrUrl,
        ]);
    }

    // ===========================
    // DOWNLOAD FILE PNG QR
    // ===========================
    public function qrDownload($id)
    {
        $kuisioner = Kuisioner::findOrFail($id);
        $targetUrl = $this->makeKuisionerPublicUrl($kuisioner);

        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=800x800&margin=10&data='
            . urlencode($targetUrl);

        $image = @file_get_contents($qrUrl);
        if ($image === false) {
            abort(500, 'Gagal mengambil gambar QR dari server.');
        }

        $filename = 'qr_kuisioner_' . $kuisioner->id . '.png';

        return response($image)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    // ================================
    // EDIT VIEW
    // ================================
    public function edit(Kuisioner $kuisioner)
    {
        $roleOptions = $this->roleOptions();
        return view('admin.kuisioner.edit', compact('kuisioner', 'roleOptions'));
    }

    // ================================
    // UPDATE (WITH DUPLICATE CHECK)
    // ================================
    public function update(Request $request, Kuisioner $kuisioner)
    {
        $request->validate([
            'judul'       => 'required|string|max:255|unique:kuisioners,judul,' . $kuisioner->id,
            'deskripsi'   => 'nullable|string',
            'target_user' => 'required|array',
        ], [
            'judul.unique' => 'Nama layanan / judul kuisioner sudah ada, silakan gunakan nama lain.',
        ]);

        $kuisioner->update([
            'judul'       => $request->judul,
            'deskripsi'   => $request->deskripsi,
            'target_user' => json_encode($request->target_user),
        ]);

        return redirect()->route('admin.kuisioner.index')
            ->with('success', 'Kuisioner berhasil diperbarui!');
    }

    // ================================
    // DELETE
    // ================================
    public function destroy(Kuisioner $kuisioner)
    {
        $kuisioner->delete();

        return redirect()->route('admin.kuisioner.index')
            ->with('success', 'Kuisioner berhasil dihapus!');
    }

    // ================================
    // TOGGLE STATUS (AKTIF / NONAKTIF)
    // ================================
    public function toggle($id)
    {
        $kuisioner = Kuisioner::findOrFail($id);

        // ✅ status 1/0, aman & konsisten
        $kuisioner->status = $kuisioner->status ? 0 : 1;
        $kuisioner->save();

        return redirect()->back()->with('success', 'Status kuisioner berhasil diubah');
    }
}
