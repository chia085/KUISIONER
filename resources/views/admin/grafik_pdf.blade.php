<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Grafik Kuisioner - {{ $kuisioner->judul }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h1, h2, h3 { margin: 4px 0; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 15px; }
        th, td { border: 1px solid #555; padding: 4px 6px; font-size: 10px; }
        th { background: #e0f2f1; }
        .small { font-size: 10px; color: #555; }
    </style>
</head>
<body>

<h1>Rekap Jawaban Kuisioner</h1>
<h2>{{ $kuisioner->judul }}</h2>

<p class="small">
    Role: <strong>{{ $role ?: 'Semua Role' }}</strong><br>
    Periode: {{ $start_date }} s/d {{ $end_date }}<br>
    Dicetak pada: {{ now()->format('d-m-Y H:i') }}
</p>

@foreach($pertanyaans as $p)
    <h3>{{ $loop->iteration }}. {{ $p->pertanyaan }}</h3>

    @php
        $rows = [];
        $total = 0;
        foreach($opsi as $o){
            $count = $jawaban->filter(fn($j) => $j->pertanyaan_id == $p->id && $j->jawaban == $o)->count();
            $rows[] = ['label'=>$o, 'jumlah'=>$count];
            $total += $count;
        }

        $isian = $jawaban->filter(fn($j) => $j->pertanyaan_id == $p->id && !in_array($j->jawaban, $opsi))
                         ->pluck('jawaban')
                         ->toArray();
    @endphp

    @if($total == 0 && empty($isian))
        <p class="small">Belum ada jawaban untuk pertanyaan ini.</p>
        <br>
        @continue
    @endif

    @if($total > 0)
    <table>
        <thead>
        <tr>
            <th>Jawaban</th>
            <th>Jumlah</th>
            <th>Persentase</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $row)
            @php
                $persen = $total > 0 ? round(($row['jumlah'] / $total) * 100, 1) : 0;
            @endphp
            <tr>
                <td>{{ $row['label'] }}</td>
                <td>{{ $row['jumlah'] }}</td>
                <td>{{ $persen }} %</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif

    @if(!empty($isian))
        <p><strong>Jawaban Isian:</strong></p>
        <ul>
            @foreach($isian as $text)
                <li>{{ $text }}</li>
            @endforeach
        </ul>
    @endif

    <hr>
@endforeach

</body>
</html>
