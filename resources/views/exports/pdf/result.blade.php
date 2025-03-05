@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Hasil Rekap Servis Kendaraan</h2>
    
    <div class="card mb-3">
        <div class="card-header">Informasi Kendaraan</div>
        <div class="card-body">
            <p>Plat Nomor: {{ $kendaraan->plat_nomor }}</p>
            <p>Jenis Kendaraan: {{ $kendaraan->jenisKendaraan->nama ?? 'Tidak Diketahui' }}</p>
            <p>Pengguna: {{ $kendaraan->pengguna->nama ?? 'Tidak Diketahui' }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Riwayat Servis</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Servis</th>
                        <th>Jenis Servis</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $index => $service)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $service->tanggal_servis->format('d-m-Y') }}</td>
                        <td>{{ $service->jenis_servis }}</td>
                        <td>{{ $service->keterangan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data servis</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        <form action="{{ route('export-servis.pdf') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="plat_nomor" value="{{ $kendaraan->plat_nomor }}">
            <input type="hidden" name="bulan" value="{{ $bulan }}">
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            <button type="submit" class="btn btn-danger">Download PDF</button>
        </form>

        <form action="{{ route('export-servis.excel') }}" method="POST" class="d-inline ml-2">
            @csrf
            <input type="hidden" name="plat_nomor" value="{{ $kendaraan->plat_nomor }}">
            <input type="hidden" name="bulan" value="{{ $bulan }}">
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            <button type="submit" class="btn btn-success">Download Excel</button>
        </form>
    </div>
</div>
@endsection