<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembelianBensin extends Model
{
    protected $table = 'pembelian_bensins';
    protected $fillable = [
        'kendaraan_id',
        'bulan',
        'tahun',
        'realisasi',
        'keterangan'
    ];

    // protected $casts = [
    //     'tanggal_beli' => 'date',
    //     'jumlah_liter' => 'decimal:2',
    //     'harga_per_liter' => 'decimal:2',
    //     'total_biaya' => 'decimal:2',
    // ];

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function getNamaBulanAttibute()
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ][$this->bulan] ?? '';
    }

    public function pengeluaran(): BelongsTo
    {
        return $this->belongsTo(Pengeluaran::class, 'pengeluaran_id');
    }
}
