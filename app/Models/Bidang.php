<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Bidang extends Model
{
    //
    use HasFactory;

    protected $table = 'bidangs';

    protected $fillable = [
        'nama_bidang',
        'kode'
    ];

    public function pengguna(): HasMany
    {
        return $this->hasMany(Pengguna::class);
    }
}
