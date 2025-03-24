<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['detail_id' => 1, 'penjualan_id' => 1, 'barang_id' => 1, 'harga' => 3500000, 'jumlah' => 1],
            ['detail_id' => 2, 'penjualan_id' => 1, 'barang_id' => 2, 'harga' => 2800000, 'jumlah' => 1],
            ['detail_id' => 3, 'penjualan_id' => 1, 'barang_id' => 3, 'harga' => 6500000, 'jumlah' => 1],
            ['detail_id' => 4, 'penjualan_id' => 2, 'barang_id' => 4, 'harga' => 150000, 'jumlah' => 2],
            ['detail_id' => 5, 'penjualan_id' => 2, 'barang_id' => 5, 'harga' => 170000, 'jumlah' => 2],
            ['detail_id' => 6, 'penjualan_id' => 2, 'barang_id' => 6, 'harga' => 300000, 'jumlah' => 1],
            // Tambahkan data lain yang sesuai dengan penjualan lainnya...
        ];

        DB::table('t_penjualan_detail')->insert($data);
    }
}