<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        DB::table('user')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'role' => '1',
            'status' => '1',
            'alamat' => 'Admin Address',
            'telp' => '123456789',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create kasir user
        DB::table('user')->insert([
            'name' => 'kasir',
            'email' => 'kasir@gmail.com',
            'password' => bcrypt('kasir'),
            'role' => '2',
            'status' => '1',
            'alamat' => 'Kasir Address',
            'telp' => '987654321',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}