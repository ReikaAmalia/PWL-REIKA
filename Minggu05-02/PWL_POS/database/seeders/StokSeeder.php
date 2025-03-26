<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    public function run()
    {
        DB::table('t_stok')->insert([
            [
                'supplier_id' => 1,
                'barang_id' => 1,
                'user_id' => 1,
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 100,
            ],
            [
                'supplier_id' => 2,
                'barang_id' => 2,
                'user_id' => 1,
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 50,
            ],
            [
                'supplier_id' => 3,
                'barang_id' => 3,
                'user_id' => 2,
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 75,
            ],
        ]);
    }
}
