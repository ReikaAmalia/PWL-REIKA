<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['penjualan_id' => 1, 'user_id' => 1, 'penjualan_kode' => 'PJ001', 'pembeli' => 'Pembeli 1', 'penjualan_tanggal' => now()],
            ['penjualan_id' => 2, 'user_id' => 1, 'penjualan_kode' => 'PJ002', 'pembeli' => 'Pembeli 2', 'penjualan_tanggal' => now()],
            ['penjualan_id' => 3, 'user_id' => 1, 'penjualan_kode' => 'PJ003', 'pembeli' => 'Pembeli 3', 'penjualan_tanggal' => now()],
            ['penjualan_id' => 4, 'user_id' => 1, 'penjualan_kode' => 'PJ004', 'pembeli' => 'Pembeli 4', 'penjualan_tanggal' => now()],
            ['penjualan_id' => 5, 'user_id' => 1, 'penjualan_kode' => 'PJ005', 'pembeli' => 'Pembeli 5', 'penjualan_tanggal' => now()],
            ['penjualan_id' => 6, 'user_id' => 1, 'penjualan_kode' => 'PJ006', 'pembeli' => 'Pembeli 6', 'penjualan_tanggal' => now()],
            ['penjualan_id' => 7, 'user_id' => 1, 'penjualan_kode' => 'PJ007', 'pembeli' => 'Pembeli 7', 'penjualan_tanggal' => now()],
            ['penjualan_id' => 8, 'user_id' => 1, 'penjualan_kode' => 'PJ008', 'pembeli' => 'Pembeli 8', 'penjualan_tanggal' => now()],
            ['penjualan_id' => 9, 'user_id' => 1, 'penjualan_kode' => 'PJ009', 'pembeli' => 'Pembeli 9', 'penjualan_tanggal' => now()],
            ['penjualan_id' => 10, 'user_id' => 1, 'penjualan_kode' => 'PJ010', 'pembeli' => 'Pembeli 10', 'penjualan_tanggal' => now()],
        ];

        DB::table('t_penjualan')->insert($data);
    }
}