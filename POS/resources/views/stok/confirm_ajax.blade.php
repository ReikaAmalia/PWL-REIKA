@empty($stok)
  {{-- Jika stok tidak ditemukan --}}
  <div class="modal-header">
    <h5 class="modal-title">Kesalahan</h5>
    <button type="button" class="close" data-dismiss="modal">
      <span>&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <div class="alert alert-danger">
      Data stok yang Anda cari tidak ditemukan.
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
  </div>
@else
  <form action="{{ url('/stok/' . $stok->stok_id . '/delete_ajax') }}" method="POST" id="form-delete">
    @csrf
    @method('DELETE')

    <div class="modal-header">
      <h5 class="modal-title">Hapus Data Stok</h5>
      <button type="button" class="close" data-dismiss="modal">
        <span>&times;</span>
      </button>
    </div>

    <div class="modal-body">
      <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        Yakin ingin menghapus data stok berikut?
      </div>
      <table class="table table-sm table-bordered">
        <tr>
          <th>Barang</th>
          <td>{{ $stok->barang->barang_nama }}</td>
        </tr>
        <tr>
          <th>Supplier</th>
          <td>{{ $stok->supplier->supplier_nama }}</td>
        </tr>
        <tr>
          <th>User</th>
          <td>{{ $stok->user->nama }}</td>
        </tr>
        <tr>
          <th>Tanggal</th>
          <td>{{ \Carbon\Carbon::parse($stok->stok_tanggal)->format('d-m-Y H:i') }}</td>
        </tr>
        <tr>
          <th>Jumlah</th>
          <td>{{ $stok->stok_jumlah }}</td>
        </tr>
      </table>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      <button type="submit" class="btn btn-danger">Ya, Hapus</button>
    </div>
  </form>

  <script>
    $(document).ready(function () {
        $("#form-delete").validate({
            rules: {},
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataStok.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endempty
