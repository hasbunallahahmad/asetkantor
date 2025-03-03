<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraans';

    protected $fillable = [
        'merk',
        'model',
        'plat_nomor',
        'nomor_mesin',
        'nomor_rangka',
        'tahun_pengadaan',
        'jenis_kendaraan_id',
        'anggaran_tahunan',
        'tanggal_pajak_tahunan',
        'tanggal_stnk_habis',
        'status'
    ];
    protected $casts = [
        'tahun_pengadaan' => 'integer',
        'anggaran_tahunan' => 'decimal:2',
        'tanggal_pajak_tahunan' => 'date',
        'tanggal_stnk_habis' => 'date',
    ];
    public function jenisKendaraan(): BelongsTo
    {
        return $this->belongsTo(JenisKendaraan::class, 'jenis_kendaraan_id');
    }

    public function penugasanKendaraan(): HasMany
    {
        return $this->hasMany(PenugasanKendaraan::class, 'kendaraan_id');
    }

    public function pengeluaran(): HasMany
    {
        return $this->hasMany(Pengeluaran::class, 'kendaraan_id');
    }

    public function servisKendaraan(): HasMany
    {
        return $this->hasMany(ServisKendaraan::class, 'kendaraan_id');
    }

    public function pembelianBensin(): HasMany
    {
        return $this->hasMany(PembelianBensin::class, 'kendaraan_id');
    }

    public function pembayaranStnk(): HasMany
    {
        return $this->hasMany(PembayaranStnk::class, 'kendaraan_id');
    }

    public function logAktivitas(): HasMany
    {
        return $this->hasMany(LogAktivitas::class, 'kendaraan_id');
    }

    // Pengguna aktif saat ini
    public function penggunaAktif()
    {
        return $this->penugasanKendaraan()
            ->whereNull('tanggal_selesai')
            ->with('pengguna')
            ->first()?->pengguna;
    }

    // Total pengeluaran dalam periode tertentu
    public function totalPengeluaran($startDate = null, $endDate = null)
    {
        $query = $this->pengeluaran();

        if ($startDate) {
            $query->where('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('tanggal', '<=', $endDate);
        }

        return $query->sum('jumlah');
    }
}
