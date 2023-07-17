<?php

namespace App\Imports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ProdukImport implements ToModel, WithStartRow, WithCustomCsvSettings
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
        if ($row[5] == null) {
            $row[5] = 0;
        }

        $produk = Produk::where('kode', $row[0])->first();
        if ($produk == null) {

            $data_produk =  new Produk([
                'kode'     => $row[0],
                'nama_produk'    => $row[1],
                'harga_beli' => $row[2],
                'harga_jual' => $row[3],
                'expired' => $row[4],
                'stok' => $row[5],
                'status' => $row[6],
            ]);
        } else {
            $data_produk = $produk;
        }

        return $data_produk;
    }
}
