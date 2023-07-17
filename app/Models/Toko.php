<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;
    protected $table = 'toko';
    protected $fillable = [
        'id',
        'nama_toko',
        'alamat_toko',
        'keterangan',
        'no_telepon_toko',
    ];
}
