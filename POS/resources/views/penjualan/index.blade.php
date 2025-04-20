@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <!-- Tombol Import dengan Modal -->
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-penjualan-import">
                    <i class="fa fa-file-import"></i> Import Penjualan
                </button>
                <a href="{{ url('/penjualan/export_excel') }}" class="btn btn-sm btn-primary"><i class="fa fa-file-excel"></i> Export Penjualan</a>
                <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-sm btn-warning"><i class="fa fa-file-pdf"></i> Export Penjualan</a>
                <button onclick="modalAction('{{ url('penjualan/create_ajax') }}')" class="btn btn-sm btn-success">
                    Tambah Data
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter Data -->
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-1 control-label col-form-label">Filter:</label>
                            <div class="col-3">
                                <select class="form-control" id="user_id" name="user_id" required>
                                    <option value="">- Semua -</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->user_id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">List User</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Penjualan</th>
                        <th>Nama User</th>
                        <th>Nama Pembeli</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal Umum -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>

    <!-- Modal Import Penjualan -->
    <form action="{{ url('/penjualan/import_ajax') }}" method="POST" id="form-import-penjualan" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="modal-penjualan-import" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Data Penjualan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Download Template</label>
                            <a href="{{ asset('template_penjualan.xlsx') }}" class="btn btn-info btn-sm" download><i class="fa fa-file-excel"></i> Download</a>
                            <small id="error-template" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Pilih File</label>
                            <input type="file" name="file_penjualan" id="file_penjualan" class="form-control" required>
                            <small id="error-file_penjualan" class="error-text form-text text-danger"></small>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('css')
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    var dataPenjualan;
    $(document).ready(function () {
        dataPenjualan = $('#table_stok').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('penjualan/list') }}",
                dataType: "json",
                type: "POST",
                data: function (d) {
                    d.user_id = $('#user_id').val();
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "penjualan_kode" },
                { data: "user.nama" },
                { data: "pembeli" },
                { data: "penjualan_tanggal" },
                { data: "aksi", orderable: false, searchable: false }
            ]
        });

        $('#table-barang_filter input').unbind().bind().on('keyup', function (e) {
            if (e.keyCode == 13) {
                dataPenjualan.search(this.value).draw();
            }
        });

        $('#user_id').on('change', function () {
            dataPenjualan.ajax.reload();
        });
    });

    // AJAX untuk Import Penjualan
    $("#form-import-penjualan").on("submit", function(e){
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr("action"),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                if(response.status){
                    $('#modal-penjualan-import').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message
                    });
                    dataPenjualan.ajax.reload();
                } else {
                    $('.error-text').text('');
                    $.each(response.msgField, function(key, val){
                        $('#error-' + key).text(val[0]);
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            }
        });
    });
</script>
@endpush
