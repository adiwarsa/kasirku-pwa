<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a toko
        DB::table('toko')->insert([
            'nama_toko' => 'Kasirku',
            'alamat_toko' => 'Toko Address',
            'no_telepon_toko' => 1234567890,
            'keterangan' => 'Toko Description',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
