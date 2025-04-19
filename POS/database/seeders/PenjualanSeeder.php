<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1, // Admin
                'pembeli' => 'Reika Amalia',
                'penjualan_kode' => 'CC01',
                'penjualan_tanggal' => Carbon::now()->subDays(1),
            ],
            [
                'user_id' => 2, // Manager
                'pembeli' => 'Ghetsa Ramadhani',
                'penjualan_kode' => 'CC02',
                'penjualan_tanggal' => Carbon::now()->subDays(2),
            ],
            [
                'user_id' => 3, // Staff
                'pembeli' => 'Cindy Larasati',
                'penjualan_kode' => 'CC03',
                'penjualan_tanggal' => Carbon::now()->subDays(3),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Vanessa',
                'penjualan_kode' => 'CC04',
                'penjualan_tanggal' => Carbon::now()->subDays(4),
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Oltha',
                'penjualan_kode' => 'CC05',
                'penjualan_tanggal' => Carbon::now()->subDays(5),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Ninis',
                'penjualan_kode' => 'CC06',
                'penjualan_tanggal' => Carbon::now()->subDays(6),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Neva',
                'penjualan_kode' => 'CC07',
                'penjualan_tanggal' => Carbon::now()->subDays(7),
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Kubu Barat',
                'penjualan_kode' => 'CC08',
                'penjualan_tanggal' => Carbon::now()->subDays(8),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Aisha Baiqa',
                'penjualan_kode' => 'CC09',
                'penjualan_tanggal' => Carbon::now()->subDays(9),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Awaw',
                'penjualan_kode' => 'CC10',
                'penjualan_tanggal' => Carbon::now()->subDays(10),
            ],
        ];

        DB::table('t_penjualan')->insert($data);
    }
}