@extends('admin.layout')

@section('content')

<form method="GET" class="flex flex-wrap items-end gap-3">
    <div>
        <label class="font-semibold text-sm block">Pilih Role</label>
        <select name="role" class="border p-2 rounded text-sm">
            <option value="semua" {{ $selectedRole=='semua' ? 'selected' : '' }}>Semua Role</option>
            @foreach($roles as $r)
                <option value="{{ $r }}" {{ $r == $selectedRole ? 'selected' : '' }}>
                    {{ ucfirst($r) }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="font-semibold text-sm block">Start Date</label>
        <input type="date" name="start_date" value="{{ $startDate ?? '' }}"
               class="border p-2 rounded text-sm">
    </div>

    <div>
        <label class="font-semibold text-sm block">End Date</label>
        <input type="date" name="end_date" value="{{ $endDate ?? '' }}"
               class="border p-2 rounded text-sm">
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
        Search
    </button>

    <a href="{{ route('admin.grafik.layanan', $kuisioner->id) }}"
       class="bg-gray-200 text-gray-800 px-4 py-2 rounded text-sm hover:bg-gray-300">
        Reset
    </a>
</form>

<div class="bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-2">{{ $kuisioner->judul }}</h2>

    <div class="mt-5">
        <h3 class="text-lg font-semibold">Hasil Penilaian</h3>

        <p>Total Responden:
            <strong>{{ $total ?? 0 }}</strong>
        </p>

        <p>Total Jawaban Masuk:
            <strong>{{ $total }}</strong>
        </p>

        <p>Presentase Kepuasan (SB + B):
            <strong>{{ $persen }}%</strong>
        </p>
    </div>

    <canvas id="grafik" height="120"></canvas>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('grafik'), {
    type: 'bar',
    data: {
        labels: ['Kepuasan'],
        datasets: [{
            label: 'Persentase Kepuasan',
            data: [{{ $persen }}],
            backgroundColor: '#1f77b4'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true, max: 100 }
        }
    }
});
</script>

@endsection
