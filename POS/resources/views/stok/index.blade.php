@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Stok Barang</h3>
            <div class="card-tools">
                <a href="{{ url('/stok/create') }}" class="btn btn-success">Tambah Data</a>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group mb-3">
                <label for="filter_semua">Filter : </label>
                <select id="filter_semua" class="col-2 control-label col-form-label">
                    <option value="">- Semua -</option>
                    @foreach($barangs as $barang)
                        <option value="barang_{{ $barang->barang_id }}">Barang - {{ $barang->barang_nama }}</option>
                    @endforeach
                    @foreach($suppliers as $supplier)
                        <option value="supplier_{{ $supplier->supplier_id }}">Supplier - {{ $supplier->supplier_nama }}</option>
                    @endforeach
                    @foreach($users as $user)
                        <option value="user_{{ $user->user_id }}">User - {{ $user->nama }}</option>
                    @endforeach
                </select>
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
                        <th>NO</th>
                        <th>Nama Barang</th>
                        <th>Supplier</th>
                        <th>User Input</th>
                        <th>Tanggal Stok</th>
                        <th>Jumlah Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    var dataStok;
    $(document).ready(function() {
        dataStok = $('#table_stok').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('stok/list') }}",
                type: "POST",
                data: function (d) {
                    let selected = $('#filter_semua').val();
                    if (selected) {
                        let parts = selected.split('_');
                        d.filter_type = parts[0];
                        d.filter_id = parts[1];
                    }
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "barang.barang_nama", orderable: true },
                { data: "supplier.supplier_nama", orderable: true },
                { data: "user.nama", orderable: true },
                { data: "stok_tanggal", orderable: true },
                { data: "stok_jumlah", orderable: true },
                { data: "aksi", className: "text-center", orderable: false, searchable: false }
            ]
        });

        $('#filter_semua').change(function() {
            dataStok.draw();
        });

        $('#table_stok_filter input').unbind().bind('keyup', function(e) {
            if (e.keyCode == 13) {
                dataStok.search(this.value).draw();
            }
        });
    });
</script>
@endpush
