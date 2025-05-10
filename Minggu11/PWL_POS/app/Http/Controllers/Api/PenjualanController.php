<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\StokModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    // Menampilkan semua penjualan
    public function index()
    {
        $penjualans = PenjualanModel::with(['user', 'detail.barang'])->get();
        return response()->json([
            'status' => true,
            'data' => $penjualans
        ]);
    }

    // Menyimpan penjualan baru
    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required|exists:m_user,user_id',
            'pembeli' => 'required|max:40',
            'penjualan_kode' => 'required|max:20',
            'penjualan_tanggal' => 'required|date',
            'barang_id' => 'required|array',
            'harga' => 'required|array',
            'jumlah' => 'required|array',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Simpan data penjualan
            $penjualan = PenjualanModel::create([
                'user_id' => $request->user_id,
                'pembeli' => $request->pembeli,
                'penjualan_kode' => $request->penjualan_kode,
                'penjualan_tanggal' => $request->penjualan_tanggal,
            ]);

            foreach ($request->barang_id as $i => $barang_id) {
                // Cek stok
                $stok = StokModel::where('barang_id', $barang_id)->first();
                if ($stok && $stok->stok_jumlah >= $request->jumlah[$i]) {
                    // Kurangi stok
                    $stok->stok_jumlah -= $request->jumlah[$i];
                    $stok->save();
                } else {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Stok barang tidak cukup atau tidak ditemukan.'
                    ]);
                }

                // Simpan detail penjualan
                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $barang_id,
                    'harga' => $request->harga[$i],
                    'jumlah' => $request->jumlah[$i],
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data penjualan berhasil disimpan.',
                'data' => $penjualan
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Menampilkan detail penjualan berdasarkan ID
    public function show($id)
    {
        $penjualan = PenjualanModel::with(['user', 'detail.barang'])->find($id);

        if (!$penjualan) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $penjualan
        ]);
    }
}