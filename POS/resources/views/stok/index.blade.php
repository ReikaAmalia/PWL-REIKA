@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">Daftar Stok Barang</h3>
    <div class="card-tools">
      <button onclick="modalAction('{{ url('/stok/import') }}')" class="btn btn-sm btn-info">Import
                    Stok</button>
                <a href="{{ url('/stok/export_excel') }}" class="btn btn-sm btn-primary"><i
                        class="fa fa-file-excel"></i> Export Stok</a>
      <a href="{{ url('/stok/export_pdf') }}" class="btn btn-sm btn-warning"><i class="fa fa-file-pdf"></i>
                          Export Stok</a>
      <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-sm btn-success">
        Tambah Data
      </button>
    </div>
  </div>
  <div class="card-body">
    <div class="form-group mb-3">
      <label for="filter_semua">Filter : </label>
      <select id="filter_semua" class="col-2 control-label col-form-label">
        <option value="">- Semua -</option>
        @foreach($barangs as $barang)
          <option value="barang_{{ $barang->barang_id }}">Barang – {{ $barang->barang_nama }}</option>
        @endforeach
        @foreach($suppliers as $supplier)
          <option value="supplier_{{ $supplier->supplier_id }}">Supplier – {{ $supplier->supplier_nama }}</option>
        @endforeach
        @foreach($users as $user)
          <option value="user_{{ $user->user_id }}">User – {{ $user->nama }}</option>
        @endforeach
      </select>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table id="table_stok" class="table table-bordered table-hover table-sm">
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

{{-- Modal Kosong, isi dari AJAX --}}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="modalContent">
      {{-- isi via AJAX --}}
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });

  var dataStok;

  $(function () {
    dataStok = $('#table_stok').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ url('stok/list') }}",
        type: "POST",
        data: function(d) {
          let sel = $('#filter_semua').val();
          if (sel) {
            let [type, id] = sel.split('_');
            d.filter_type = type;
            d.filter_id = id;
          }
        }
      },
      columns: [
        { data: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'barang.barang_nama' },
        { data: 'supplier.supplier_nama' },
        { data: 'user.nama' },
        { data: 'stok_tanggal' },
        { data: 'stok_jumlah' },
        { data: 'aksi', orderable: false, searchable: false }
      ]
    });

    $('#filter_semua').change(() => dataStok.draw());
  });

  // Fungsi untuk load modal via AJAX (tambah/edit/hapus)
  function modalAction(url) {
    $.get(url)
      .done(function(html) {
        $('#modalContent').html(html);
        $('#myModal').modal('show');

        // Jalankan validasi jika form-tambah ada
        if ($("#form-tambah").length) {
          $("#form-tambah").validate({
            rules: {
              barang_id: { required: true },
              stok_tanggal: { required: true },
              stok_jumlah: { required: true, digits: true }
            }
          });
        }

        // Jalankan validasi jika form-delete ada
        if ($("#form-delete").length) {
          $("#form-delete").validate({
            submitHandler: function(form) {
              $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                  if (response.status) {
                    $('#myModal').modal('hide');
                    Swal.fire('Berhasil', response.message, 'success');
                    dataStok.ajax.reload();
                  } else {
                    Swal.fire('Gagal', response.message, 'error');
                  }
                },
                error: function() {
                  Swal.fire('Error', 'Gagal menghapus data.', 'error');
                }
              });
              return false;
            }
          });
        }

      })
      .fail(function() {
        Swal.fire('Error', 'Gagal memuat form.', 'error');
      });
  }

  // Submit form tambah (via AJAX)
  $(document).on('submit', '#form-tambah', function(e) {
    e.preventDefault();
    let form = this;

    $.ajax({
      url: form.action,
      type: form.method,
      data: $(form).serialize(),
      success: function(response) {
        $('.error-text').text('');
        if (response.status) {
          $('#myModal').modal('hide');
          Swal.fire('Berhasil', response.message, 'success');
          dataStok.ajax.reload();
        } else {
          $.each(response.msgField, function(field, message) {
            $('#error-' + field).text(message[0]);
          });
          Swal.fire('Gagal', response.message, 'error');
        }
      },
      error: function() {
        Swal.fire('Error', 'Gagal koneksi ke server.', 'error');
      }
    });
  });
</script>
@endpush
