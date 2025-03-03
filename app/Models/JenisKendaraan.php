<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class JenisKendaraan extends Model
{
    //
    use HasFactory;
    protected $table = 'jenis_kendaraans';
    protected $fillable = [
        'nama',
        'jumlah_roda'
    ];

    public function kendaraans(): HasMany
    {
        return $this->hasMany(Kendaraan::class, 'jenis_kendaraan_id');
    }
}
