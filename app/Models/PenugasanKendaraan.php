<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenugasanKendaraan extends Model
{
    use HasFactory;

    protected $table = 'penugasan_kendaraans';

    protected $fillable = [
        'kendaraan_id',
        'pengguna_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan'
    ];

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
