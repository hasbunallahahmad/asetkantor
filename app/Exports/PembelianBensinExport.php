<?php

namespace App\Exports;

use App\Models\PembelianBensin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PembelianBensinExport implements FromCollection
{
    protected $bulan, $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }
    public function collection()
    {
        return PembelianBensin::where('bulan', $this->bulan)
            ->where('tahun', $this->tahun)
            ->get(['tanggal_beli', 'jumlah_liter', 'harga_per_liter', 'jumlah_harga']);
    }
    public function headings(): array
    {
        return ['Tanggal', 'Jumlah Liter', 'Harga/Liter', 'Total Harga'];
    }
}
