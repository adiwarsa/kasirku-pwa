<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = [
        'id',
        'id_supplier',
        'kode',
        'nama_produk',
        'harga_beli',
        'harga_jual',
        'sub_total',
        'expired',
        'stok',
        'produk_supplier_terjual',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
}
