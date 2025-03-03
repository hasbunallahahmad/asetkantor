<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranStnk extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_stnks';
    protected $fillable = [
        'kendaraan_id',
        'tanggal_bayar',
        'biaya',
        'jenis_pembayaran',
        'berlaku_hingga',
        'pengeluaran_id',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'berlaku_hingga' => 'date',
        'biaya' => 'decimal:2',
    ];

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function pengeluaran(): BelongsTo
    {
        return $this->belongsTo(Pengeluaran::class, 'pengeluaran_id');
    }

    // Helper method to automatically calculate berlaku_hingga based on jenis_pembayaran
    public function calculateBerlakuHingga(string $jenisPembayaran, $tanggalBayar): \Carbon\Carbon
    {
        $tanggal = \Carbon\Carbon::parse($tanggalBayar);

        if ($jenisPembayaran === 'TNKB') {
            return $tanggal->addYears(5);
        }

        // STNK Tahunan
        return $tanggal->addYear();
    }
}
