<?php

namespace App\Exports;

use App\Models\ServisKendaraan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServisKendaraanExport implements FromCollection
{
    protected $plat_nomor;

    public function __construct($plat_nomor)
    {
        $this->plat_nomor = $plat_nomor;
    }

    public function collection()
    {
        return ServisKendaraan::whereHas('kendaraan', function ($query) {
            $query->where('plat_nomor', $this->plat_nomor);
        })
            ->get(['tanggal_servis', 'jenis_servis', 'biaya', 'bengkel', 'keterangan']);
    }
    public function headings(): array
    {
        return ['Tanggal Servis', 'Jenis Servis', 'Biaya', 'Bengkel', 'Keterangan'];
    }
}
