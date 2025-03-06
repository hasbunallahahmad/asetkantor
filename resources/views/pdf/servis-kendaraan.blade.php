<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Laporan Servis Kendaraan {{ $kendaraan->plat_nomor }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }
        .kendaraan-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }
        .kendaraan-info h2 {
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
            font-size: 12px;
            padding: 8px;
        }
        td {
            padding: 8px;
            font-size: 12px;
        }
        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN SERVIS KENDARAAN</h1>
        <p>Tanggal Cetak: {{ $tanggal_cetak }}</p>
    </div>

    <div class="kendaraan-info">
        <h2>Detail Kendaraan</h2>
        <div class="info-grid">
            <div>
                <p><strong>Plat Nomor:</strong> {{ $kendaraan->plat_nomor }}</p>
                <p><strong>Tipe Kendaraan:</strong> {{ $kendaraan->tipe_kendaraan ?? '-' }}</p>
            </div>
            <div>
                <p><strong>Merek:</strong> {{ $kendaraan->merek ?? '-' }}</p>
                <p><strong>Tahun:</strong> {{ $kendaraan->tahun ?? '-' }}</p>
            </div>
        </div>
    </div>

    <h2>Riwayat Servis</h2>
    
    @if(count($records) > 0)
        <table>
            <thead>
                <tr>
                    <th>Tanggal Servis</th>
                    <th>Jenis Servis</th>
                    <th>KM</th>
                    <th>Bengkel</th>
                    <th>Biaya</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                    <tr>
                        <td>{{ $record->tanggal_servis->format('d/m/Y') }}</td>
                        <td>{{ $record->jenis_servis }}</td>
                        <td>{{ number_format($record->kilometer_kendaraan) }} KM</td>
                        <td>{{ $record->bengkel ?? '-' }}</td>
                        <td>Rp{{ number_format($record->biaya, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;">Total:</td>
                    <td>Rp{{ number_format($total_biaya, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <p>Tidak ada data servis untuk kendaraan ini.</p>
    @endif

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis dari Sistem Manajemen Kendaraan</p>
    </div>
</body>
</html>