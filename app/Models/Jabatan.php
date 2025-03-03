<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    //
    use HasFactory;
    protected $table = 'jabatans';
    protected $fillable = [
        'nama_jabatan',
        'kode'
    ];

    public function penggunas(): HasMany
    {
        return $this->hasMany(Pengguna::class, 'jabatan_id');
    }
}
