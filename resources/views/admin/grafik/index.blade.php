@extends('admin.layout')

@section('title', 'Grafik Kepuasan Layanan')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">

    {{-- ================= HEADER + FILTER TANGGAL ================= --}}
    <div class="flex flex-col gap-4 mb-4">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-teal-600">
                    Hasil Kepuasan Layanan Unit Kerja Polibatam
                </h2>
                <p class="text-gray-600 text-sm">
                    Rekap total responden dan persentase kepuasan (Sangat Baik + Baik) untuk setiap layanan.
                </p>
            </div>

            {{-- Tombol-tombol aksi --}}
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.grafik.export.excel', [
                        'start_date' => $startDate,
                        'end_date'   => $endDate,
                    ]) }}"
                   class="bg-green-500 text-white px-3 py-2 rounded text-xs md:text-sm hover:bg-green-600">
                    Export Excel
                </a>

                <a href="{{ route('admin.grafik.export.pdf', [
                        'start_date' => $startDate,
                        'end_date'   => $endDate,
                    ]) }}"
                   class="bg-red-500 text-white px-3 py-2 rounded text-xs md:text-sm hover:bg-red-600">
                    Export PDF
                </a>

                <a href="{{ route('admin.grafik.pilih') }}"
                   class="bg-teal-600 text-white px-3 py-2 rounded text-xs md:text-sm hover:bg-teal-700">
                    Lihat Grafik per Layanan
                </a>
            </div>
        </div>

        {{-- ====== FORM FILTER TANGGAL ====== --}}
        <form method="GET"
              action="{{ route('admin.grafik') }}"
              class="bg-gray-50 border rounded-lg px-4 py-3 flex flex-col md:flex-row gap-3 md:items-end">

            <div class="flex-1">
                <label class="block text-xs font-semibold text-gray-600 mb-1">
                    Tanggal Mulai
                </label>
                <input type="date"
                       name="start_date"
                       value="{{ $startDate }}"
                       class="w-full border rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>

            <div class="flex-1">
                <label class="block text-xs font-semibold text-gray-600 mb-1">
                    Tanggal Selesai
                </label>
                <input type="date"
                       name="end_date"
                       value="{{ $endDate }}"
                       class="w-full border rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="bg-teal-600 text-white px-4 py-2 rounded text-sm font-semibold hover:bg-teal-700">
                    Terapkan Filter
                </button>

                <a href="{{ route('admin.grafik') }}"
                   class="border border-gray-300 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-100">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- ================= CEK DATA ================= --}}
    @php
        $data = $data ?? [];
    @endphp

    @if(count($data) === 0)
        <p class="text-center text-gray-500 py-6">
            Belum ada data jawaban untuk rentang tanggal ini.
        </p>
    @else
        <div class="w-full overflow-x-auto">
            <canvas id="grafikKeseluruhan" height="140"></canvas>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
(function () {
    const el = document.getElementById('grafikKeseluruhan');
    if (!el) return;

    const data = @json($data);

    const labels   = data.map(d => d.judul);
    const totalRes = data.map(d => Number(d.total  || 0));
    const persen   = data.map(d => Number(d.persen || 0));

    new Chart(el, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Jumlah Responden',
                    data: totalRes,
                    backgroundColor: 'rgba(255, 159, 64, 0.8)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Persentase Kepuasan (%)',
                    data: persen,
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            scales: {
                x: { beginAtZero: true }
            }
        }
    });
})();
</script>
@endsection
