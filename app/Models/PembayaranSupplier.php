<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranSupplier extends Model
{
    use HasFactory;
    protected $table = 'pembayaran_supplier';
    protected $fillable = [
        'id',
        'id_supplier',
        'nama_produk_supplier',
        'total_penjualan',
        'total_pembayaran',
        'tanggal',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
}
