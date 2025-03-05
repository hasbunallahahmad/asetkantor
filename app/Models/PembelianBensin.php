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
        'pengguna_id',
        'tanggal_beli',
        'bulan',
        'tahun',
        'jatah_liter_per_hari',
        'jatah_liter_per_bulan',
        'jenis_bbm',
        'jumlah_liter',
        'harga_per_liter',
        'jumlah_harga',
        'kilometer_kendaraan',
        'pengeluaran_id',
        'keterangan',
    ];

    protected $casts = [
        'jatah_liter_per_hari' => 'decimal:2',
        'jatah_liter_per_bulan' => 'decimal:2',
        'jumlah_liter' => 'decimal:2',
        'harga_per_liter' => 'decimal:2',
        'jumlah_harga' => 'decimal:2',
    ];

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function getNamaBulanAttribute()
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

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
    public function getJenisBbmOptions()
    {
        return [
            'PERTAMAX' => 'PERTAMAX',
            'PERTAMAX DEX' => 'PERTAMAX DEX',
            'PERTAMAX TURBO' => 'PERTAMAX TURBO',
            'DEXLITE' => 'DEXLITE',
            'PERTALITE' => 'PERTALITE',
            'SOLAR' => 'SOLAR'
        ];
    }
}
