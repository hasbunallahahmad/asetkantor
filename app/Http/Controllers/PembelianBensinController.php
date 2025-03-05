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
            'tanggal_beli' => 'required|date',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer',
            'jumlah_liter' => 'required|numeric|min:0',
            'harga_per_liter' => 'required|numeric|min:0',
            'jatah_liter_per_hari' => 'required|numeric',
            'jumlah_harga' => 'required|numeric',
            // 'pengguna_id' => 'required|exists:penggunas,id',
            'realisasi' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        //ambil pengguna dari kendaraan
        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        // $validated['pengguna_id'] = $kendaraan->pengguna_id;

        if (!$kendaraan->pengguna) {
            return back()->withErrors('Kendaraan tidak memiliki pengguna terdaftar');
        }
        // $pengguna_id = $kendaraan->pengguna_id ?? 0;

        // Simpan data dengan pengguna_id
        $pembelianBensin = PembelianBensin::create([
            'kendaraan_id' => $request->kendaraan_id,
            'pengguna_id' => $kendaraan->pengguna->id,
            'tanggal_beli' => $request->tanggal_beli,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jatah_liter_per_hari' => $kendaraan->jatah_liter_per_hari,
            'jenis_bbm' => $request->jenis_bbm,
            'jumlah_liter' => $request->jumlah_liter,
            'harga_per_liter' => $request->harga_per_liter,
            'jumlah_harga' => $request->jumlah_liter * $request->harga_per_liter,
            'keterangan' => $request->keterangan,
        ]);


        $validated['tahun'] = now()->year;

        $validated['jumlah_harga'] = $validated['jumlah_liter'] * $validated['harga_per_liter'];

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
