<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\Kuisioner;

class AdminLoginController extends Controller
{
    // ✅ Form Login Admin
    public function showLogin()
    {
        return view('admin.login');
    }

    // ✅ Proses Login
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

    // ✅ Dashboard
    public function dashboard()
    {
        if (!Session::get('is_admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.dashboard');
    }

    // ✅ Logout
    public function logout()
    {
        Session::forget('is_admin_logged_in');
        return redirect()->route('admin.login');
    }

    // ✅ Halaman Analisis (Filter Kuisioner & Role)
    public function analisis(Request $request)
    {
        if (!Session::get('is_admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Ambil semua role unik dari tabel jawabans
        $roles = Jawaban::select('role')->distinct()->pluck('role');

        // Ambil semua kuisioner
        $kuisioners = Kuisioner::select('id', 'judul')->get();

        // Filter input
        $selectedRole = $request->get('role');
        $selectedKuisioner = $request->get('kuisioner_id');

        // Gunakan relasi antar model (Eloquent)
        $query = Jawaban::with(['pertanyaan.kuisioner']);

        // Filter Role (jika dipilih)
        if (!empty($selectedRole)) {
            $query->where('role', $selectedRole);
        }

        // Filter Kuisioner (jika dipilih)
        if (!empty($selectedKuisioner)) {
            $query->whereHas('pertanyaan', function ($q) use ($selectedKuisioner) {
                $q->where('kuisioner_id', $selectedKuisioner);
            });
        }

        // Ambil hasil akhir
        $jawabans = $query->orderBy('created_at', 'desc')->get();

        return view('admin.analisis', compact(
            'roles',
            'kuisioners',
            'jawabans',
            'selectedRole',
            'selectedKuisioner'
        ));
    }
    public function generateQR($id)
{
    $kuisioner = Kuisioner::findOrFail($id);

    // URL yang akan diarahkan saat QR discan
    $targetUrl = route('kuisioner.show', ['id' => $kuisioner->id]);

    // QR generator API
    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($targetUrl);

    return view('admin.kuisioner.qr', compact('kuisioner', 'qrUrl', 'targetUrl'));
}
    // ✅ Halaman Grafik
    public function grafik()
    {
        if (!Session::get('is_admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.grafik');
    }
}
