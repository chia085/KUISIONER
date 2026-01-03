<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Export Jawaban</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin: 0 0 6px 0; }
        .meta { margin-bottom: 12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; vertical-align: top; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Jawaban Responden</h2>
    <div class="meta">
        <div><b>Kuisioner:</b> {{ $judulKuisioner }}</div>
        <div><b>Periode:</b>
            {{ $startDate ? $startDate : '-' }} s/d {{ $endDate ? $endDate : '-' }}
        </div>
        <div><b>Tipe:</b> {{ $tipe }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Kuisioner</th>
                <th>Pertanyaan</th>
                <th>Role</th>
                <th>Jawaban</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jawabans as $j)
                <tr>
                    <td>{{ optional($j->created_at)->format('d-m-Y H:i') }}</td>
                    <td>{{ $j->kuisioner->judul ?? '-' }}</td>
                    <td>{{ $j->pertanyaan->pertanyaan ?? '-' }}</td>
                    <td>{{ $j->role ?? '-' }}</td>
                    <td>{{ $j->jawaban ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Tidak ada data jawaban.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
