<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Kuisioner - {{ $kuisioner->judul }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-5xl mx-auto mt-8">
    <div class="bg-teal-600 text-white p-5 rounded-lg shadow">
        <h1 class="text-xl font-bold">Hasil Kuisioner: {{ $kuisioner->judul }}</h1>
        <p class="text-sm mt-1">Anda mengisi sebagai: <b>{{ ucfirst($role) }}</b></p>
    </div>

    <div class="mt-5 space-y-6">
        @foreach($data as $d)
        <div class="bg-white p-5 rounded-lg shadow">
            <h2 class="font-semibold mb-3">{{ $d['pertanyaan'] }}</h2>

            @if(array_sum($d['chart']) > 0)
                <canvas id="chart_{{ $d['id'] }}" height="120"></canvas>
            @else
                <p class="text-gray-500 text-sm">Belum ada jawaban untuk pertanyaan ini.</p>
            @endif

            @if(count($d['isian']) > 0)
                <div class="mt-4">
                    <h3 class="font-semibold text-sm mb-2">Isian Responden:</h3>
                    <ul class="list-disc ml-5 text-sm text-gray-700">
                        @foreach($d['isian'] as $i)
                            <li>{{ $i }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

<script>
@foreach($data as $d)
const ctx{{ $d['id'] }} = document.getElementById('chart_{{ $d['id'] }}');
if (ctx{{ $d['id'] }}) {
    new Chart(ctx{{ $d['id'] }}, {
        type: 'bar',
        data: {
            labels: @json($d['opsi']),
            datasets: [{
                label: 'Jumlah',
                data: @json($d['chart']),
                backgroundColor: 'rgba(16, 185, 129, 0.5)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });
}
@endforeach
</script>

</body>
</html>
