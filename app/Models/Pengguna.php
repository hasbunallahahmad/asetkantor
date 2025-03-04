<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengguna extends Model
{
    //
    use HasFactory;

    protected $table = 'penggunas';
    protected $fillable = [
        'nama',
        'nip',
        'jabatan_id',
        'bidang_id',
        'email',
        'no_telp'
    ];

    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class, 'pengguna_id');
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class);
    }
    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class);
    }
    public function penugasanKendaraan(): HasMany
    {
        return $this->hasMany(PenugasanKendaraan::class);
    }

    public function pengeluaran(): HasMany
    {
        return $this->hasMany(Pengeluaran::class, 'created_by');
    }

    public function logAktivitas(): HasMany
    {
        return $this->hasMany(LogAktivitas::class);
    }

    public function pembelianBensin(): HasMany
    {
        return $this->hasMany(PembelianBensin::class);
    }
}
