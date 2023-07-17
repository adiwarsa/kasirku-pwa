<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';
    protected $fillable = [
        'id',
        'id_user',
        'invoice',
        'qty',
        'sub_total',
        'pembayaran',
        'pembayaran_transfer',
        'sisa',
        'kembalian',
        'status',
        'jatuh_tempo',
        'keterangan_hutang',
        'nama_pemilik_bank',
        'jenis_bank',
        'bank_tujuan',
        'tanggal',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
