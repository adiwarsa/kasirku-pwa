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
    protected $appends = [
        'formatted_created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    //Mengubah format tanggal created_at menjadi Hari, tanggal bulan tahun, jam menit detik
    public function getFormattedCreatedAtAttribute(): string {
        return $this->created_at->isoFormat('D MMMM YYYY, HH:mm:ss');
    }
}
