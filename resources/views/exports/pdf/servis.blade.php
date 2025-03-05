{{-- <!DOCTYPE html>
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
</html> --}}

{{-- ### File: resources/views/export/pdf/servis.blade.php
```blade --}}
<!DOCTYPE html>
<html>
<head>
    <title>Rekap Service Kendaraan Bermotor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .vehicle-info {
            margin-bottom: 15px;
        }
        .vehicle-info label {
            display: inline-block;
            width: 120px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: center;
        }
        .table-header {
            background-color: #f0f0f0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>REKAP SERVICE KENDARAAN BERMOTOR</h2>
    </div>

    <div class="vehicle-info">
        <div>
            <label>Plat Nomor</label>: {{ $kendaraan->plat_nomor }}
        </div>
        <div>
            <label>Jenis Kendaraan</label>: {{ $kendaraan->jenisKendaraan->nama ?? 'Tidak Diketahui' }}
        </div>
        <div>
            <label>Pengguna</label>: {{ $kendaraan->pengguna->nama ?? 'Tidak Diketahui' }}
        </div>
    </div>

    <table>
        <thead>
            <tr class="table-header">
                <th>No</th>
                <th>Tanggal Servis</th>
                <th>Jenis Servis</th>
                <th>Keterangan</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @php $counter = 1 @endphp
            @foreach($services as $service)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $service->tanggal_servis?->format('d-m-Y') }}</td>
                    <td>{{ $service->jenis_servis }}</td>
                    <td>{{ $service->keterangan }}</td>
                    <td></td>
                </tr>
            @endforeach

            {{-- Fill remaining rows --}}
            @for($i = count($services); $i < 6; $i++)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>