<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    protected $table = 'laporan';
    protected $fillable = [
        'id',
        'id_invoice',
        'kode_produk',
        'nama_produk',
        'keuntungan_per_item',
        'total_keuntungan',
        'harga_jual',
        'qty',
        'sub_total',
        'tanggal',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'id_invoice');
    }
}
