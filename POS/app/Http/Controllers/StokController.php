<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;


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
                // $btn = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/' . $stok->stok_id) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                // return $btn;

                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
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



        public function create_ajax()
    {
        $suppliers = SupplierModel::all();
        $users = UserModel::all();
        $barangs = BarangModel::all();

        return view('stok.create_ajax', [
            'suppliers' => $suppliers,
            'users' => $users,
            'barangs' => $barangs,
        ]);
    }

        public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $stok = StokModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil disimpan',
                'data' => $stok
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }


        // Edit data stok via AJAX
  public function edit_ajax(string $id)
  {
    $stok = stokModel::find($id);
    $barang = BarangModel::all();
    $user = UserModel::all();
    $supplier = SupplierModel::all();

    return view('stok.edit_ajax', compact('stok', 'barang', 'user', 'supplier'));
  }

  // Update data stok via AJAX
  public function update_ajax(Request $request, string $id)
  {
    if ($request->ajax() || $request->wantsJson()) {
      $rules = [
        'barang_id' => 'required|integer',
        'user_id' => 'required|integer',
        'supplier_id' => 'required|integer',
        'stok_tanggal' => 'required|date',
        'stok_jumlah' => 'required|integer|min:1',
      ];

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return response()->json([
          'status' => false,
          'message' => 'Validasi gagal.',
          'msgField' => $validator->errors()
        ]);
      }

      $stok = stokModel::find($id);
      if ($stok) {
        $stok->update($request->all());

        return response()->json([
          'status' => true,
          'message' => 'Data stok berhasil diupdate'
        ]);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data stok tidak ditemukan'
        ]);
      }
    }

    return redirect('/');
  }

  public function show_ajax($id)
{
    $stok = StokModel::with(['barang', 'user', 'supplier'])->find($id);

    if (!$stok) {
        return response()->json([
            'status' => false,
            'message' => 'Data stok tidak ditemukan'
        ]);
    }

    return view('stok.show_ajax', compact('stok'));
}


// Tampilkan modal konfirmasi hapus
public function confirm_ajax(string $id)
{
    $stok = StokModel::find($id);

    if (!$stok) {
        return response()->view('stok._notfound', [], 404);
    }

    return view('stok.confirm_ajax', compact('stok'));
}

// Proses AJAX hapus
public function delete_ajax(Request $request, string $id)
{
    if ($request->ajax() || $request->wantsJson()) {
        $stok = StokModel::find($id);

        if (!$stok) {
            return response()->json([
                'status' => false,
                'message' => 'Data stok tidak ditemukan'
            ]);
        }

        try {
            $stok->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data. Mungkin terkait dengan data lain.'
            ]);
        }
    }

    return redirect('/');
}

public function export_pdf()
{
    $stok = StokModel::with(['barang', 'supplier', 'user'])->get();
    $pdf = Pdf::loadView('stok.export_pdf', compact('stok'));
    return $pdf->stream('laporan_stok.pdf');
}

public function import()
{
    return view('stok.import');
}


public function import_ajax(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'file_stok' => ['required', 'mimes:xlsx', 'max:1024']
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $file = $request->file('file_stok');
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, false, true, true);

        $insert = [];

        if (count($data) > 1) {
            foreach ($data as $baris => $value) {
                if ($baris > 1) {
                    $insert[] = [
                        'barang_id'     => $value['A'],
                        'user_id'   => $value['B'],
                        'supplier_id'   => $value['C'], // atau sesuaikan jika pakai user login
                        'stok_tanggal'  => $value['D'],        // atau bisa ambil dari Excel jika ada
                        'stok_jumlah'   => $value['E'],
                        'created_at'    => now(),
                    ];
                }
            }

            if (count($insert) > 0) {
                StokModel::insert($insert);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil diimport'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang diimport'
            ]);
        }
    }

    return redirect('/');
}

public function export_excel()
{
    // ambil data stok yang akan di-export
    $stok = StokModel::select('stok_id', 'supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
    ->orderBy('barang_id')
    ->with('user')->with('supplier')->with('barang')
    ->get();


    // load library excel
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // header kolom
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Tanggal');
    $sheet->setCellValue('C1', 'Nama Barang');
    $sheet->setCellValue('D1', 'Supplier');
    $sheet->setCellValue('E1', 'Jumlah');
    $sheet->setCellValue('F1', 'User Input');

    $sheet->getStyle('A1:F1')->getFont()->setBold(true); // bold header

    $no = 1;
    $baris = 2;
    foreach ($stok as $item) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $item->stok_tanggal);
        $sheet->setCellValue('C' . $baris, $item->barang->barang_nama ?? '-');
        $sheet->setCellValue('D' . $baris, $item->supplier->supplier_nama ?? '-');
        $sheet->setCellValue('E' . $baris, $item->stok_jumlah);
        $sheet->setCellValue('F' . $baris, $item->user->name ?? 'User ID: '.$item->user_id);
        $baris++;
        $no++;
    }

    foreach (range('A', 'F') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $sheet->setTitle('Data Stok');

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $filename = 'Data Stok_' . date('Y-m-d H-i-s') . '.xlsx';

    // header untuk download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $writer->save('php://output');
    exit;
}



} 
