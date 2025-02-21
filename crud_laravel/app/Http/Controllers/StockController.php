<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Menampilkan daftar dari stock
     */
    public function index()
    {
        $stocks = Stock::all(); //mengambil data-data yang ada pada stock database
        return view('stocks.index', compact('stocks'));// menampilkan tampilan 'stocks.index' dengan data stock yang ada
    }

    /**
     * Menampilkan form untuk membuat stock baru
     */
    public function create()
    {
        return view('stocks.create');// Mengembalikan tampilan dari 'stocks.create' untuk membuat form stock yang baru
    }

    /**
     * Menyimpan data stock baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required', // Memvalidasi untuk 'name' wajib diisi
            'description' => 'required', // Memvalidasi untuk 'description' wajib diisi
        ]);

        //hanya masukkan atribut yang diizinkan yaitu 'name' dan 'description'
        Stock::create($request->only(['name', 'description']));

        return redirect()->route('stocks.index')->with('success', 'Stock added successfully.'); // mengarahkan pada halaman index dengan pesan sukses jika berhasil 
    }

    /** Menampilkan data stock yang dipilih
     */
    public function show(Stock $stock)
    {
        return view('stocks.show', compact('stock'));// Mengembalikan tampilan 'stocks.show' dengan data yang sebenarnya
    }

    /**
     * Menampilkan form untuk mengedit stock yg sudah dipilih
     */
    public function edit(Stock $stock)
    {
        return view('stocks.edit', compact('stock'));// Mengembalikan tampilan dari 'stocks.edit' dengan data stok yang dipilih untuk diedit
    }

    /**
     * Memperbarui stock yang dipilih dalam database
     */
    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'name' => 'required', // Memvalidasi untuk 'name' wajib diisi
            'description' => 'required',  // Memvalidasi untuk 'description' wajib diisi
        ]);//beri komen

        $stock->update($request->only(['name', 'description']));// Memperbarui atribut 'name' dan 'description' dari stock yang dipilih
        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully.');// Mengembalikan kembali ke halaman index dengan pesan sukses jika berhasil
    }

    /**
     * Menghapus stock yang dipilih dari database
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();// Menghapus stock yang dipilih dari database
        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully.');// Mengembalikan kembali ke halaman index dengan pesan sukses jika berhasil
    }
}
