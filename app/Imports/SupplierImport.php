<?php

namespace App\Imports;

use App\Models\Produk;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class SupplierImport implements ToModel, WithStartRow, WithCustomCsvSettings
{
    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[3] == null) {
            $row[3] = 0;
        }
        $supplier1 = Supplier::where('nama_supplier', $row[0])->first();

        if ($supplier1 == null) {
            Supplier::create([
                'nama_supplier' => $row[0],
                'no_wa'    => $row[1],
                'keterangan' => $row[2],
                'total_pembayaran' => $row[3],
                'tanggal' => $row[4],
                'status' => $row[5],
            ]);
        }

        if ($row[11] == null) {
            $row[11] = 0;
        }

        if ($row[14] == null) {
            $row[14] = 0;
        }


        $supplier2 = Supplier::where('nama_supplier', $row[6])->first();
        $produk = Produk::where('kode', $row[7])->first();

        if ($produk == null) {
            $data_produk_supplier = new Produk([
                'supplier_id' => $supplier2->id,
                'kode' => $row[7],
                'nama_produk' => $row[8],
                'harga_beli' => $row[9],
                'harga_jual' => $row[10],
                'sub_total' => $row[11],
                'expired' => $row[12],
                'stok' => $row[13],
                'produk_supplier_terjual' => $row[14],
                'status' => $row[15],
            ]);
        } else {
            $data_produk_supplier = $produk;
        }

        return $data_produk_supplier;
    }
}
