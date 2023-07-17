<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $table = 'keranjang';
    protected $fillable = [
        'id',
        'id_user',
        'kode_produk',
        'nama_produk',
        'keuntungan_per_item',
        'total_keuntungan',
        'harga_jual',
        'qty',
        'sub_total',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
