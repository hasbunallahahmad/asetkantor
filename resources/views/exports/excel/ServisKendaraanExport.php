<?php

namespace App\Exports;

use App\Models\ServisKendaraan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServisKendaraanExport implements FromCollection, WithHeadings
{
  protected $kendaraanId;
  protected $bulan;
  protected $tahun;

  public function __construct($kendaraanId, $bulan, $tahun)
  {
    $this->kendaraanId = $kendaraanId;
    $this->bulan = $bulan;
    $this->tahun = $tahun;
  }

  public function collection()
  {
    return ServisKendaraan::where('kendaraan_id', $this->kendaraanId)
      ->whereMonth('tanggal_servis', $this->bulan)
      ->whereYear('tanggal_servis', $this->tahun)
      ->select('tanggal_servis', 'jenis_servis', 'keterangan')
      ->get();
  }

  public function headings(): array
  {
    return [
      'Tanggal Servis',
      'Jenis Servis',
      'Keterangan'
    ];
  }
}
