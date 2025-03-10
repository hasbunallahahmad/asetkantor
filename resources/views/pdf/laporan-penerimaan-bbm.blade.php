<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Penerimaan BBM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 8pt;
            line-height: 1.3;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 14pt;
            font-weight: bold;
            margin: 2px 0;
            /* padding: 0; */
        }

        .header h2 {
            font-size: 12pt;
            font-weight: bold;
            margin: 2px 0;
            /* padding: 0; */
        }

        .header h3 {
            font-size: 10pt;
            font-weight: bold;
            margin: 2px 0;
            /* padding: 0; */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* Penting untuk ukuran kolom tetap */
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 8pt;
            overflow: hidden;
            word-wrap: break-word;
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
            font-size: 9pt;
            margin-top: 5px 0;
            text-align: center;
            margin-left: auto;
            margin-right: 0;
            width: 60%;
            float: right;
        }

        .signature-space {
            height: 50px;
            /* Lebih tinggi untuk ruang tanda tangan */
        }

        .total-row {
            font-weight: bold;
        }

        /* Penyesuaian lebar kolom */
        table th:nth-child(1),
        table td:nth-child(1) {
            width: 3%;
            /* Nomor */
        }

        table th:nth-child(2),
        table td:nth-child(2) {
            width: 11%;
            /* Jenis Kendaraan */
        }

        table th:nth-child(3),
        table td:nth-child(3) {
            width: 7%;
            /* Tahun */
        }

        table th:nth-child(4),
        table td:nth-child(4) {
            width: 6%;
            /* Merk */
        }

        table th:nth-child(5),
        table td:nth-child(5) {
            width: 8%;
            /* No. Polisi */
        }

        table th:nth-child(6),
        table td:nth-child(6) {
            width: 5%;
            /* Liter/Hari */
        }

        table th:nth-child(7),
        table td:nth-child(7) {
            width: 5%;
            /* DLM 1 Bulan */
        }

        table th:nth-child(8),
        table td:nth-child(8) {
            width: 9%;
            /* Jenis BBM */
        }

        table th:nth-child(9),
        table td:nth-child(9) {
            width: 6%;
            /* Jumlah Liter */
        }

        table th:nth-child(10),
        table td:nth-child(10) {
            width: 7%;
            /* Harga(Rp)/Liter */
        }

        table th:nth-child(11),
        table td:nth-child(11) {
            width: 2%;
            /* Jumlah */
        }

        table th:nth-child(12),
        table td:nth-child(12) {
            width: 12%;
            /* Pemegang */
        }

        table th:nth-child(13),
        table td:nth-child(13) {
            width: 16%;
            /* Tanda Tangan */
        }

        /* Menambahkan tinggi baris untuk ruang tanda tangan */
        tbody tr {
            height: 25px;
        }

        /* Styling untuk nomor tanda tangan ganjil (di kiri) */
        td.signature-left {
            text-align: left;
            padding-left: 15px;
            vertical-align: middle;
            height: 25px;
        }

        /* Styling untuk nomor tanda tangan genap (di tengah) */
        td.signature-center {
            text-align: center;
            vertical-align: middle;
            height: 25px;
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
                <th>NO</th>
                <th>JENIS KENDARAAN</th>
                <th>TAHUN</th>
                <th>MERK</th>
                <th>NO. POLISI</th>
                <th>LTR/ HARI</th>
                <th>DLM 1 BLN</th>
                <th>JENIS BBM</th>
                <th>JML LITER</th>
                <th>PER LITER</th>
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
                    <td class="{{ ($index + 1) % 2 == 1 ? 'signature-left' : 'signature-center' }}">
                        {{ $index + 1 }}.</td>
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
