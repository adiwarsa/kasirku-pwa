<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukExport implements FromCollection, WithCustomCsvSettings, WithHeadings
{
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function headings(): array
    {
        return ["Kode", "Nama Produk", "Harga Beli", "Harga Jual", "Expired", "Stok", "Status"];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Produk::where('status', 'non-supplier')->select('kode', 'nama_produk', 'harga_beli', 'harga_jual', 'expired', 'stok', 'status')->orderBy('stok', 'DESC')->get();
    }
}
