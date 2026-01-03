<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Grafik Keseluruhan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background: #eee;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<h2>Hasil Kepuasan Layanan – Keseluruhan</h2>

<table>
    <thead>
        <tr>
            <th>Layanan</th>
            <th>Total Responden</th>
            <th>Persentase</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row['judul'] }}</td>
            <td>{{ $row['total'] }}</td>
            <td>{{ $row['persen'] }}%</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
