@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Export Rekap Servis Kendaraan</h2>
    <form action="{{ route('export-servis.export') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Plat Nomor</label>
            <select name="plat_nomor" class="form-control" required>
                <option value="">Pilih Plat Nomor</option>
                @foreach($platNomors as $plat)
                    <option value="{{ $plat }}">{{ $plat }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Bulan</label>
            <select name="bulan" class="form-control" required>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <label>Tahun</label>
            <input type="number" name="tahun" class="form-control" 
                   value="{{ date('Y') }}" 
                   min="2000" 
                   max="{{ date('Y') }}" 
                   required>
        </div>
        <button type="submit" class="btn btn-primary">Tampilkan Data</button>
    </form>
</div>
@endsection