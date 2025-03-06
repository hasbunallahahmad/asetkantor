<?php

namespace App\Exports;

use App\Models\ServisKendaraan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ServisKendaraanExport implements FromCollection, WithHeadings, WithMapping
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
            ->get([
                'tanggal_servis',
                'jenis_servis',
                'biaya',
                'bengkel',
                'keterangan'
            ]);

        // ->map(function ($item) {
        //     return [
        //         'tanggal_servis' => Carbon::parse($item->tanggal_servis)->format('d-m-Y'),
        //         'jenis_servis' => $item->jenis_servis,
        //         'biaya' => $item->biaya,
        //         'bengkel' => $item->bengkel,
        //         'keterangan' => $item->keterangan,
        //     ];
        // });
    }
    public function map($item): array
    {
        return [
            Carbon::parse($item->tanggal_servis)->format('d-m-Y'),
            $item->jenis_servis,
            number_format($item->biaya, 0, ',', '.'), // Format rupiah tanpa desimal
            $item->bengkel,
            $item->keterangan,
        ];
    }
    public function headings(): array
    {
        return ['Tanggal Servis', 'Jenis Servis', 'Biaya (Rp)', 'Bengkel', 'Keterangan'];
    }
}
