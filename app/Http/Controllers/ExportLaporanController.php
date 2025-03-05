<?php

namespace App\Http\Controllers;

use App\Models\PembelianBensin;
use App\Models\ServisKendaraan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PembelianBensinExport;
use App\Exports\ServisKendaraanExport;


class ExportLaporanController extends Controller
{
    public function exportPdfBbm(Request $request)
    {
        $data = PembelianBensin::where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->get();

        $pdf = PDF::loadView('exports.pdf-bbm', compact('data'));
        return $pdf->download('laporan-bbm.pdf');
    }

    public function exportExcelBbm(Request $request)
    {
        return Excel::download(new PembelianBensinExport($request->bulan, $request->tahun), 'laporan-bbm.xlsx');
    }
    public function exportPdfServis(Request $request, $plat_nomor)
    {

        $kendaraan = Kendaraan::where('plat_nomor', $plat_nomor)
            ->firstorFail();

        $kendaraan = Kendaraan::with('jenisKendaraan    ')
            ->where('plat_nomor', $plat_nomor)
            ->firstOrFail();
        // $kendaraan = Kendaraan::with(['jenisKendaraan' => function ($query) {
        //     $query->select('id', 'nama');
        // }])
        //     ->where('plat_nomor', $plat_nomor)->firstOrFail();

        // $kendaraan = Kendaraan::with(['pengguna'])
        //     ->where('plat_nomor', $plat_nomor)->firstOrFail();
        $kendaraan = Kendaraan::with('pengguna')
            ->where('plat_nomor', $plat_nomor)
            ->firstOrFail();

        $services = ServisKendaraan::where('kendaraan_id', $kendaraan->id)
            ->orderBy('tanggal_servis', 'asc')
            ->get();

        $pdf = Pdf::loadView('exports.pdf.servis', [
            'kendaraan' => $kendaraan,
            'services' => $services
        ]);

        return $pdf->download("rekap_servis_{$kendaraan->plat_nomor}.pdf");
        // $data = ServisKendaraan::whereHas('kendaraan', function ($query) use ($request) {
        //     $query->where('plat_nomor', $request->plat_nomor);
        // })
        //     ->get();

        // $pdf = Pdf::loadView('exports.pdf.servis', compact('data'));
        // return $pdf->download('rekap_servis.pdf');
    }

    public function exportExcelServis(Request $request)
    {
        return Excel::download(new ServisKendaraanExport($request->plat_nomor), 'rekap_servis.xlsx');
    }
}
