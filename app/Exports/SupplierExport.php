<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SupplierExport implements FromCollection, WithCustomCsvSettings, WithHeadings
{
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function headings(): array
    {
        return [
            "Nama Supplier",
            "No WhatsApp",
            "keterangan",
            "Total Pembayaran",
            "Tanggal",
            "Status",
            "Nama Supplier Produk",
            "Kode",
            "Nama Produk",
            "Harga Beli",
            "Harga Jual",
            "Sub Total",
            "Expired",
            "Stok",
            "Produk Supplier Terjual",
            "status"
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $produk = Produk::with('supplier')->where('status', 'supplier')->get();
        if ($produk->count() == 0) {
            $data_all_supplier = [];
        }
        foreach ($produk as $key => $value) {
            $data_all_supplier[] = array(
                $value->supplier->nama_supplier,
                $value->supplier->no_wa,
                $value->supplier->keterangan,
                $value->supplier->total_pembayaran,
                $value->supplier->tanggal,
                $value->supplier->status,
                $value->supplier->nama_supplier,
                $value->kode,
                $value->nama_produk,
                $value->harga_beli,
                $value->harga_jual,
                $value->sub_total,
                $value->expired,
                $value->stok,
                $value->produk_supplier_terjual,
                $value->status,
            );
        }

        return collect($data_all_supplier);
    }
}
