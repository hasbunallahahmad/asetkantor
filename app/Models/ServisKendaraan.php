<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServisKendaraan extends Model
{
    use HasFactory;
    protected $table = 'servis_kendaraans';
    protected $fillable = [
        'kendaraan_id',
        'tanggal_servis',
        'jenis_servis',
        'kilometer_kendaraan',
        'bengkel',
        'biaya',
        'keterangan',
        'pengeluaran_id'
    ];
    protected $casts = [
        'tanggal_servis' => 'date',
        'biaya' => 'decimal:2',
    ];

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }
    public function pengeluaran(): BelongsTo
    {
        return $this->belongsTo(Pengeluaran::class, 'pengeluaran_id');
    }
}
