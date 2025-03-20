<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['barang_id' => 1, 'barang_kode' => 'B001', 'barang_nama' => 'Televisi', 'harga_beli' => 3000000, 'harga_jual' => 3500000, 'kategori_id' => 1],
            ['barang_id' => 2, 'barang_kode' => 'B002', 'barang_nama' => 'Kulkas', 'harga_beli' => 2500000, 'harga_jual' => 2800000, 'kategori_id' => 1],
            ['barang_id' => 3, 'barang_kode' => 'B003', 'barang_nama' => 'Laptop', 'harga_beli' => 6000000, 'harga_jual' => 6500000, 'kategori_id' => 1],
            ['barang_id' => 4, 'barang_kode' => 'B004', 'barang_nama' => 'Kemeja', 'harga_beli' => 100000, 'harga_jual' => 150000, 'kategori_id' => 2],
            ['barang_id' => 5, 'barang_kode' => 'B005', 'barang_nama' => 'Celana', 'harga_beli' => 120000, 'harga_jual' => 170000, 'kategori_id' => 2],
            ['barang_id' => 6, 'barang_kode' => 'B006', 'barang_nama' => 'Sepatu', 'harga_beli' => 250000, 'harga_jual' => 300000, 'kategori_id' => 2],
            ['barang_id' => 7, 'barang_kode' => 'B007', 'barang_nama' => 'Roti', 'harga_beli' => 15000, 'harga_jual' => 20000, 'kategori_id' => 3],
            ['barang_id' => 8, 'barang_kode' => 'B008', 'barang_nama' => 'Susu', 'harga_beli' => 20000, 'harga_jual' => 25000, 'kategori_id' => 4],
            ['barang_id' => 9, 'barang_kode' => 'B009', 'barang_nama' => 'Sofa', 'harga_beli' => 1500000, 'harga_jual' => 1800000, 'kategori_id' => 5],
            ['barang_id' => 10, 'barang_kode' => 'B010', 'barang_nama' => 'Meja', 'harga_beli' => 500000, 'harga_jual' => 600000, 'kategori_id' => 5],
        ];

        DB::table('m_barang')->insert($data);
    }
}