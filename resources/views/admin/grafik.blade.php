@extends('admin.layout')

@section('title', 'Grafik Kuisioner – Model B')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-md">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
        <div>
            <h2 class="text-2xl font-bold text-teal-600">Grafik Kuisioner – Model B</h2>
            <p class="text-gray-600 text-sm">
                Rekap jawaban per pertanyaan, per opsi (Sangat Baik s/d Sangat Buruk).
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-200">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    {{-- FILTER --}}
    <form method="GET" action="{{ route('admin.grafik') }}" class="grid md:grid-cols-4 gap-4 mb-6">

        {{-- Pilih Kuisioner --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Pilih Kuisioner</label>
            <select name="kuisioner_id" class="w-full border rounded p-2 text-sm">
                @foreach($kuisionerList as $k)
                    <option value="{{ $k->id }}"
                        {{ $selectedKuisioner && $selectedKuisioner->id == $k->id ? 'selected' : '' }}>
                        {{ $k->judul }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Role --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Role Responden</label>
            <select name="role" class="w-full border rounded p-2 text-sm">
                <option value="semua" {{ $selectedRole === null ? 'selected' : '' }}>
                    Semua Role
                </option>
                @foreach($roleList as $r)
                    <option value="{{ $r }}" {{ $selectedRole === $r ? 'selected' : '' }}>
                        {{ ucfirst($r) }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if(!$selectedKuisioner)
        <p class="text-center text-gray-500 py-6">
            Belum ada kuisioner aktif.
        </p>
    @else

        {{-- Header Info --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <div>
                <h3 class="text-lg font-bold text-teal-700">
                    {{ $selectedKuisioner->judul }}
                </h3>
                <p class="text-sm text-gray-500">
                    Role:
                    <span class="font-semibold">{{ $selectedRole ? ucfirst($selectedRole) : 'Semua Role' }}</span>
                    &middot;
                    Total Jawaban:
                    <span class="font-semibold">{{ $grandTotal }}</span>
                </p>
            </div>

            @if($grandTotal > 0)
            <div class="space-x-2">
                <a href="{{ route('admin.grafik.export.excel', [
                        'kuisioner_id' => $selectedKuisioner->id,
                        'role'         => $selectedRole ?? 'semua',
                        'start_date'   => request('start_date'),
                        'end_date'     => request('end_date'),
                    ]) }}"
                    class="bg-green-600 text-white px-3 py-2 rounded text-xs hover:bg-green-700">
                    Export Excel
                </a>

                <a href="{{ route('admin.grafik.export.pdf', [
                        'kuisioner_id' => $selectedKuisioner->id,
                        'role'         => $selectedRole ?? 'semua',
                        'start_date'   => request('start_date'),
                        'end_date'     => request('end_date'),
                    ]) }}"
                    class="bg-red-600 text-white px-3 py-2 rounded text-xs hover:bg-red-700">
                    Export PDF
                </a>
            </div>
            @endif
        </div>

        @if($grandTotal == 0)
            <p class="text-center text-gray-500 py-6">Belum ada jawaban.</p>
        @else

        {{-- GRID --}}
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($pertanyaanData as $p)
                <div class="border rounded-lg p-4 shadow-sm">

                    <h4 class="text-sm font-semibold mb-2">
                        {{ $loop->iteration }}. {{ $p['pertanyaan'] }}
                    </h4>

                    {{-- Jika pilihan ganda ada jawaban --}}
                    @if($p['total'] > 0)
                        <canvas id="chart_{{ $p['id'] }}" height="140" class="mb-3"></canvas>

                        <table class="text-xs w-full border-collapse">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-1 text-left">Jawaban</th>
                                    <th class="p-1 text-right">Jumlah</th>
                                    <th class="p-1 text-right">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($p['rows'] as $row)
                                    @php
                                        $persen = $p['total'] > 0 ? round($row['jumlah'] / $p['total'] * 100, 1) : 0;
                                    @endphp
                                    <tr>
                                        <td class="p-1">{{ $row['label'] }}</td>
                                        <td class="p-1 text-right">{{ $row['jumlah'] }}</td>
                                        <td class="p-1 text-right">{{ $persen }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    {{-- Jawaban Isian --}}
                    @if(!empty($p['isian']))
                        <div class="mt-3">
                            <strong class="text-xs">Jawaban Isian:</strong>
                            <ul class="list-disc ml-4 text-xs mt-1 space-y-1">
                                @foreach($p['isian'] as $text)
                                    <li>{{ $text }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            @endforeach
        </div>

        @endif

    @endif

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if($selectedKuisioner && $grandTotal > 0)
<script>
function randomColor(alpha = 0.7) {
    const r = Math.floor(Math.random() * 180) + 40;
    const g = Math.floor(Math.random() * 180) + 40;
    const b = Math.floor(Math.random() * 180) + 40;
    return {
        border: `rgba(${r},${g},${b},1)`,
        background: `rgba(${r},${g},${b},${alpha})`
    };
}

@foreach($pertanyaanData as $p)
@if($p['total'] > 0)
(function() {
    const ctx = document.getElementById('chart_{{ $p['id'] }}').getContext('2d');
    const colors = randomColor();
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($p['chartLabels']) !!},
            datasets: [{
                label: 'Jumlah Jawaban',
                data: {!! json_encode($p['chartData']) !!},
                borderColor: colors.border,
                backgroundColor: colors.background,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });
})();
@endif
@endforeach
</script>
@endif

@endsection
