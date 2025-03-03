<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\PembelianBensin;
use Illuminate\Http\Request;

class PembelianBensinController extends Controller
{
    public function create()
    {
        $kendaraans = Kendaraan::orderBy('plat_nomor')->get();
        $bulan = [
            1 => 'januari',
            2 => 'februari',
            3 => 'maret',
            4 => 'april',
            5 => 'mei',
            6 => 'juni',
            7 => 'juli',
            8 => 'agustus',
            9 => 'september',
            10 => 'oktober',
            11 => 'november',
            12 => 'desember',
        ];
        return view('pembelian-bensin.create', compact('kendaraans', 'bulan'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'bulan' => 'required|integer|min:1|max:12',
            'realisasi' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $validated['tahun'] = now()->year;

        // Check if entry already exists for this vehicle/month/year
        $existing = PembelianBensin::where('kendaraan_id', $validated['kendaraan_id'])
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->first();

        if ($existing) {
            $existing->update($validated);
            $message = 'Data pembelian bensin berhasil diperbarui';
        } else {
            PembelianBensin::create($validated);
            $message = 'Data pembelian bensin berhasil disimpan';
        }
        return redirect()->route('dashboard')->with('success', $message);
    }

    public function getAnggaran($kendaraanId)
    {
        $kendaraan = Kendaraan::findOrFail($kendaraanId);
        return response()->json([
            'anggaran' => $kendaraan->anggaran_tahunan,
        ]);
    }
}
