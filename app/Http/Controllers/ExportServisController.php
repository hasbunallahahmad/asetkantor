<?php

namespace App\Http\Controllers;

use App\Exports\ServisKendaraanExport as ServisKendaraanExport;
use Illuminate\Http\Request;
use App\Models\Kendaraan;
use App\Models\Pengguna;
use App\Models\JenisKendaraan;
use App\Models\ServisKendaraan;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ExportServisController extends Controller
{
    public function index()
    {
        $platNomors = Kendaraan::pluck('plat_nomor');
        return view('export-servis.index', compact('platNomors'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|exists:kendaraans,plat_nomor',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2000|max:value(now)',
        ]);

        $kendaraan = Kendaraan::with(['jenisKendaraan', 'pengguna'])
            ->where('plat_nomor', $request->plat_nomor)
            ->firstOrFail();

        $services = ServisKendaraan::where('kendaraan_id', $kendaraan->id)
            ->whereMonth('tanggal_servis', $request->bulan)
            ->whereYear('tanggal_servis', $request->tahun)
            ->orderBy('tanggal_servis', 'asc')
            ->get();

        return view('export-servis.result', [
            'kendaraan' => $kendaraan,
            'services' => $services,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $kendaraan = Kendaraan::with(['jenisKendaraan', 'pengguna'])
            ->where('plat_nomor', $request->plat_nomor)
            ->firstOrFail();

        $services = ServisKendaraan::where('kendaraan_id', $kendaraan->id)
            // ->whereMonth('tanggal_servis', $request->bulan)
            // ->whereYear('tanggal_servis', $request->tahun)
            ->orderBy('tanggal_servis', 'asc')
            ->get();

        if ($request->has('bulan') && $request->has('tahun')) {
            $services = $services->filter(function ($service) use ($request) {
                $tanggalServis = Carbon::parse($service->tanggal_servis);
                return $service->tanggal_servis->month == $request->bulan
                    && $service->tanggal_servis->year == $request->tahun;
            });
        }

        $pdf = Pdf::loadView('export-servis.pdf', [
            'kendaraan' => $kendaraan,
            'services' => $services,
            // 'bulan' => $request->bulan,
            // 'tahun' => $request->tahun
        ]);

        // return $pdf->download("rekap_servis_{$kendaraan->plat_nomor}_{$request->bulan}_{$request->tahun}.pdf");
        return $pdf->download("rekap_servis_{$kendaraan->plat_nomor}.pdf");
    }

    public function downloadExcel(Request $request)
    {
        $kendaraan = Kendaraan::where('plat_nomor', $request->plat_nomor)->firstOrFail();

        return Excel::download(
            new ServisKendaraanExport(
                $kendaraan->id,
                $request->bulan,
                $request->tahun
            ),
            "rekap_servis_{$kendaraan->plat_nomor}_{$request->bulan}_{$request->tahun}.xlsx"
        );
    }
}
