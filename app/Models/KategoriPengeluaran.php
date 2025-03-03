<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriPengeluaran extends Model
{
    use HasFactory;

    protected $table = 'kategori_pengeluarans';

    protected $fillable = [
        'nama_kategori',
        'keterangan'
    ];

    public function pengeluarans(): HasMany
    {
        return $this->hasMany(Pengeluaran::class, 'kategori_id');
    }
}
