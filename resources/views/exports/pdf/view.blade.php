<!DOCTYPE html>
<html>
<head>
    <title>Rekap Servis Kendaraan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 5px; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Rekap Servis Kendaraan</h2>
    <p>Plat Nomor: {{ $kendaraan->plat_nomor }}</p>
    <p>Jenis Kendaraan: {{ $kendaraan->jenisKendaraan->nama ?? 'Tidak Diketahui' }}</p>
    <p>Pengguna: {{ $kendaraan->pengguna->nama ?? 'Tidak Diketahui' }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Servis</th>
                <th>Jenis Servis</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $index => $service)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $service->tanggal_servis->format('d-m-Y') }}</td>
                <td>{{ $service->jenis_servis }}</td>
                <td>{{ $service->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>