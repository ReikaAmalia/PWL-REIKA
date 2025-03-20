<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use App\DataTables\KategoriDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        // $data = [
        //     'kategori_kode' => 'SNK',
        //     'kategori_nama' => 'Snack/Makanan Ringan',
        //     'created_at' => now()
        // ];
        // DB::table('m_kategori')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Camilan']);
        // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
        // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';

        return $dataTable->render('kategori.index');
    }

        public function create()
    {
        return view('kategori.create');
    }

        public function store(Request $request)
    {
        KategoriModel::create([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori,
        ]);


        return redirect('/kategori');
    }

    public function edit($id)
    {
        // Cari kategori berdasarkan ID
        $kategori = KategoriModel::findOrFail($id);
    
        // Tampilkan view edit dan kirim data kategori
        return view('kategori.edit', compact('kategori'));
    }
    

    // Method untuk menyimpan update kategori
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'kategori_kode' => 'required|string|max:50',
            'kategori_nama' => 'required|string|max:100',
        ]);

        // Temukan kategori berdasarkan ID
        $kategori = KategoriModel::findOrFail($id);

        // Update data kategori
        $kategori->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        // Redirect kembali ke halaman kategori dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function delete($id)
    {
        KategoriModel::where('kategori_id', $id)->delete();
        return redirect(to: '/kategori');
    }
}