{{-- <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Penerimaan BBM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.3;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }

        .header h2 {
            font-size: 12pt;
            font-weight: bold;
            margin: 5px 0;
            padding: 0;
        }

        .header h3 {
            font-size: 11pt;
            font-weight: bold;
            margin: 5px 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 12pt;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

        .signature-space {
            height: 20px;
        }

        .total-row {
            font-weight: bold;
        }

        .signature-table {
            width: 50%;
            margin-left: 40px;
            margin-top: 20px;
        }

        .signature-cell {
            height: 30px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>DAFTAR PENERIMAAN BBM KENDARAAN DINAS</h1>
        <h2>DINAS ARSIP DAN PERPUSTAKAAN KOTA SEMARANG</h2>
        <h3>BULAN : {{ $bulan }} {{ $tahun }}</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>NO.</th>
                <th>JENIS KENDARAAN</th>
                <th>TAHUN</th>
                <th>MERK</th>
                <th>NO. POLISI</th>
                <th>LITER/HARI</th>
                <th>DLM 1 BULAN</th>
                <th>JENIS BBM</th>
                <th>JUMLAH LITER</th>
                <th>HARGA(Rp)/LITER</th>
                <th>JUMLAH</th>
                <th>PEMEGANG</th>
                <th>TANDA TANGAN</th>
            </tr>
            <tr>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>
                <th>11</th>
                <th>12</th>
                <th>13</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}.</td>
                    <td>{{ $item->kendaraan->jenis ?? 'KENDARAAN RODA 4' }}</td>
                    <td class="text-center">{{ $item->kendaraan->tahun_pengadaan ?? '-' }}</td>
                    <td>{{ $item->kendaraan->merk ?? '-' }}</td>
                    <td class="text-center">{{ $item->kendaraan->plat_nomor ?? '-' }}</td>
                    <td class="text-center">{{ number_format($item->jatah_liter_per_hari, 0) }}</td>
                    <td class="text-center">{{ number_format($item->jatah_liter_per_bulan, 0) }}</td>
                    <td class="text-center">{{ $item->jenis_bbm }}</td>
                    <td class="text-center">{{ number_format($item->jumlah_liter, 0) }}</td>
                    <td class="text-center">{{ number_format($item->harga_per_liter, 0) }}</td>
                    <td class="text-center">{{ number_format($item->jumlah_harga, 0) }}</td>
                    <td>{{ $item->pengguna->nama ?? '-' }}</td>
                    <td class="{{ $index % 2 == 0 ? 'signature-left' : 'signature-center' }}">{{ $index + 1 }}.
                    </td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="10" class="text-center">JUMLAH</td>
                <td class="text-center">{{ number_format($totalJumlah, 0) }}</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    {{-- <!-- Tabel tanda tangan -->
    <table class="signature-table">
        <thead>
            <tr>
                <th colspan="1" class="text-center">TANDA TANGAN</th>
            </tr>
            <tr>
                <th>13</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 8; $i++)
            <tr>
                <td class="signature-cell">{{ $i }}.</td>
            </tr>
            @endfor
        </tbody>
    </table> --}}

{{-- <div class="footer">
        <p>Semarang, {{ $tanggalCetak }}</p>
        <p>Kuasa Pengguna Anggaran</p>
        <p>Dinas Arsip dan Perpustakaan Kota Semarang</p>
        <div class="signature-space"></div>
        <p><strong>Dr. Muhammad Ahsan, S.Ag, M.Kom</strong></p>
    </div>
</body>

</html> --}}

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Penerimaan BBM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.3;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }

        .header h2 {
            font-size: 16pt;
            font-weight: bold;
            margin: 5px 0;
            padding: 0;
        }

        .header h3 {
            font-size: 14pt;
            font-weight: bold;
            margin: 5px 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 12pt;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            text-align: left;
            margin-left: auto;
            margin-right: 150px;
            /* Geser ke kanan */
            width: max-content;
        }

        .signature-space {
            height: 50px;
        }

        .total-row {
            font-weight: bold;
        }

        /* Menyesuaikan lebar kolom */
        th:nth-child(5),
        td:nth-child(5) {
            width: 9%;
            /* Nomor Polisi lebih lebar */
        }

        th:nth-child(6),
        td:nth-child(6) {
            width: 5%;
            /* Liter/Hari lebih kecil */
        }

        th:nth-child(10),
        td:nth-child(10) {
            width: 86;
            /* Harga(Rp)/Liter lebih kecil */
        }

        th:nth-child(12),
        td:nth-child(12) {
            width: 10%;
            /* Pemegang lebih besar */
        }

        th:nth-child(13),
        td:nth-child(13) {
            width: 10%;
            /* Tanda tangan lebih besar */
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>DAFTAR PENERIMAAN BBM KENDARAAN DINAS</h1>
        <h2>DINAS ARSIP DAN PERPUSTAKAAN KOTA SEMARANG</h2>
        <h3>BULAN : {{ $bulan }} {{ $tahun }}</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>NO.</th>
                <th>JENIS KENDARAAN</th>
                <th>TAHUN</th>
                <th>MERK</th>
                <th>NO. POLISI</th>
                <th>LITER/HARI</th>
                <th>DLM 1 BULAN</th>
                <th>JENIS BBM</th>
                <th>JUMLAH LITER</th>
                <th>HARGA(Rp)/LITER</th>
                <th>JUMLAH</th>
                <th>PEMEGANG</th>
                <th>TANDA TANGAN</th>
            </tr>
            <tr>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>
                <th>11</th>
                <th>12</th>
                <th>13</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}.</td>
                    <td>{{ $item->kendaraan->jenis ?? 'KENDARAAN RODA 4' }}</td>
                    <td class="text-center">{{ $item->kendaraan->tahun_pengadaan ?? '-' }}</td>
                    <td>{{ $item->kendaraan->merk ?? '-' }}</td>
                    <td class="text-center">{{ $item->kendaraan->plat_nomor ?? '-' }}</td>
                    <td class="text-center">{{ number_format($item->jatah_liter_per_hari, 0) }}</td>
                    <td class="text-center">{{ number_format($item->jatah_liter_per_bulan, 0) }}</td>
                    <td class="text-center">{{ $item->jenis_bbm }}</td>
                    <td class="text-center">{{ number_format($item->jumlah_liter, 0) }}</td>
                    <td class="text-center">{{ number_format($item->harga_per_liter, 0) }}</td>
                    <td class="text-center">{{ number_format($item->jumlah_harga, 0) }}</td>
                    <td>{{ $item->pengguna->nama ?? '-' }}</td>
                    <td class="text-center">{{ $index + 1 }}.</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="10" class="text-center">JUMLAH</td>
                <td class="text-center">{{ number_format($totalJumlah, 0) }}</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Semarang, {{ $tanggalCetak }}</p>
        <p>Kuasa Pengguna Anggaran</p>
        <p>Dinas Arsip dan Perpustakaan Kota Semarang</p>
        <div class="signature-space"></div>
        <p><strong>Dr. Muhammad Ahsan, S.Ag, M.Kom</strong></p>
    </div>
</body>

</html>
