<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'supplier';
    protected $fillable = [
        'id',
        'nama_supplier',
        'no_wa',
        'keterangan',
        'total_pembayaran',
        'tanggal',
        'status',
    ];
}
