<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar Stok yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok';

        $suppliers = SupplierModel::all();
        $users = UserModel::all();
        $barangs = BarangModel::all();

        return view('stok.index', ['breadcrumb' => $breadcrumb,'page' => $page,'suppliers' => $suppliers,'users' => $users,'barangs' => $barangs,'activeMenu' => $activeMenu]);
    }


    public function list(Request $request)
    {
        $stoks = StokModel::with(['supplier', 'barang', 'user']);
    
        // Filter tunggal berdasarkan tipe dan id (gabungan dari dropdown)
        if ($request->filter_type && $request->filter_id) {
            if ($request->filter_type === 'barang') {
                $stoks->where('barang_id', $request->filter_id);
            } elseif ($request->filter_type === 'supplier') {
                $stoks->where('supplier_id', $request->filter_id);
            } elseif ($request->filter_type === 'user') {
                $stoks->where('user_id', $request->filter_id);
            }
        }
    
        return DataTables::of($stoks)
            ->addIndexColumn()
            ->editColumn('stok_tanggal', function ($stok) {
                return Carbon::parse($stok->stok_tanggal)->format('d-m-Y H:i:s');
            })
            ->addColumn('aksi', function ($stok) {
                $btn = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/' . $stok->stok_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    


    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Data',
            'list' => ['Home', 'Stok', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Data'
        ];

        $suppliers = SupplierModel::all();
        $users = UserModel::all();
        $barangs = BarangModel::all();
        $activeMenu = 'stok';

        return view('stok.create', ['breadcrumb' => $breadcrumb,'page' => $page,'suppliers' => $suppliers,'users' => $users,'barangs' => $barangs,'activeMenu' => $activeMenu]);
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:0',
        ]);

        StokModel::create($request->all());

        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }

    public function show(string $id)
    {
        $stok = StokModel::with(['supplier', 'barang', 'user'])->find($id);

        if (!$stok) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Stok',
            'list' => ['Home', 'Stok', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Stok'
        ];

        $activeMenu = 'stok';

        return view('stok.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'stok' => $stok,
            'activeMenu' => $activeMenu
        ]);
    }

    
    public function edit(string $id)
    {
        $stok = StokModel::find($id);

        if (!$stok) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        $suppliers = SupplierModel::all();
        $users = UserModel::all();
        $barangs = BarangModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Stok'
        ];

        $activeMenu = 'stok';

        return view('stok.edit', ['breadcrumb' => $breadcrumb,'page' => $page,'stok' => $stok,'suppliers' => $suppliers,'users' => $users,'barangs' => $barangs,'activeMenu' => $activeMenu]);
    }

   
    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:0',
        ]);

        $stok = StokModel::find($id);

        if (!$stok) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        $stok->update($request->all());

        return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    }


    public function destroy(string $id)
    {
        $stok = StokModel::find($id);

        if (!$stok) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            $stok->delete();
            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terkait dengan data lain');
        }
    }
}
