<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Servis Kendaraan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Rekap Servis Kendaraan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Servis</th>
                <th>Jenis Servis</th>
                <th>Biaya</th>
                <th>Bengkel</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $servis)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $servis->tanggal_servis }}</td>
                <td>{{ $servis->jenis_servis }}</td>
                <td>Rp {{ number_format($servis->biaya, 2, ',', '.') }}</td>
                <td>{{ $servis->bengkel }}</td>
                <td>{{ $servis->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
