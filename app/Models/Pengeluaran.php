<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluarans';

    protected $fillable = [
        'kendaraan_id',
        'kategori_id',
        'tanggal',
        'jumlah',
        'keterangan',
        'bukti_pembayaran',
        'created_by'
    ];
    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriPengeluaran::class, 'kategori_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'created_by');
    }

    public function servisKendaraan(): HasOne
    {
        return $this->hasOne(ServisKendaraan::class);
    }

    public function pembayaranStnk(): HasOne
    {
        return $this->hasOne(PembayaranStnk::class);
    }

    public function pembelianBensin(): HasOne
    {
        return $this->hasOne(PembelianBensin::class);
    }
}
