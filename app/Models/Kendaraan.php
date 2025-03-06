<?php

namespace App\Models;

use App\Models\JenisKendaraan;
use App\Models\Pengguna;
use App\Models\PembayaranStnk;
use App\Models\PembelianBensin;
use App\Models\ServisKendaraan;
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
        'tahun',
        'jenis_kendaraan_id',
        // 'jenis',
        'jatah_liter_per_hari',
        'anggaran_tahunan',
        'tanggal_pajak_tahunan',
        'tanggal_stnk_habis',
        'status',
        'pengguna_id',
    ];
    protected $casts = [
        'tahun_pengadaan' => 'integer',
        'anggaran_tahunan' => 'decimal:2',
        'tanggal_pajak_tahunan' => 'date',
        'tanggal_stnk_habis' => 'date',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->jatah_liter_per_hari = $model->jenis_kendaraan === 'roda_4' ? 7 : 1;
        });
    }
    // Di App\Models\Kendaraan.php
    public function jenisKendaraan()
    {
        return $this->belongsTo(JenisKendaraan::class, 'jenis_kendaraan_id');
    }
    public function getJenisAttribute()
    {
        // If 'jenis' is not set but jenis_kendaraan relation exists, return that
        if (empty($this->attributes['jenis']) && $this->jenisKendaraan) {
            return $this->jenisKendaraan->nama; // Assuming the name is stored in 'nama' field
        }
        return $this->attributes['jenis'] ?? 'KENDARAAN RODA 4'; // Default value
    }
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
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
    // public function penugasanAktif()
    // {
    //     return $this->hasOne(PenugasanKendaraan::class, 'kendaraan_id')
    //         ->whereNull('tanggal_selesai');
    // }
    // Pengguna aktif saat ini
    // public function penggunaSaatIni()
    // {
    //     return $this->hasOneThrough(
    //         Pengguna::class,
    //         PenugasanKendaraan::class,
    //         'kendaraan_id', // Kunci asing pada PenugasanKendaraan
    //         'id', // Kunci primer pada Pengguna
    //         'id', // Kunci primer pada Kendaraan
    //         'pengguna_id' // Kunci asing pada PenugasanKendaraan
    //     )->whereNull('penugasan_kendaraans.tanggal_selesai');
    // }

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
