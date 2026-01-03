<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Grafik {{ $kuisioner->judul }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

<div class="max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold text-center mb-6">
        Hasil Kepuasan — {{ $kuisioner->judul }}
    </h1>

    <div class="bg-white p-6 rounded-xl shadow">

        <canvas id="barChart"></canvas>

        <div class="mt-6 text-center text-gray-600">
            <p><b>Total Responden:</b> {{ $totalResponden }}</p>
            <p><b>Persentase Baik/Sangat Baik:</b> {{ $persen }}%</p>
        </div>

    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('polibatam') }}"
           class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
            Kembali
        </a>
    </div>

</div>

<script>
const ctx = document.getElementById('barChart').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['{{ $kuisioner->judul }}'],
        datasets: [
            {
                label: 'Jumlah Responden',
                data: [{{ $totalResponden }}],
                backgroundColor: '#F97316' // orange
            },
            {
                label: 'Persentase Baik/Sangat Baik (%)',
                data: [{{ $persen }}],
                backgroundColor: '#1D4ED8' // biru
            },
        ]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        },
        scales: {
            x: { beginAtZero: true }
        }
    }
});
</script>

</body>
</html>
