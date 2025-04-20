<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Edit Data Stok</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <form action="{{ url('/stok/' . $stok->stok_id . '/update_ajax') }}" method="POST" id="form-edit-stok">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <!-- Barang -->
            <div class="form-group">
                <label>Barang</label>
                <select class="form-control" name="barang_id" required>
                    <option value="">- Pilih Barang -</option>
                    @foreach($barang as $item)
                        <option value="{{ $item->barang_id }}" @selected($item->barang_id == $stok->barang_id)>
                            {{ $item->barang_nama }}
                        </option>
                    @endforeach
                </select>
                <small id="error-barang_id" class="text-danger"></small>
            </div>

            <!-- Pengguna -->
            <div class="form-group">
                <label>Pengguna</label>
                <select class="form-control" name="user_id" required>
                    <option value="">- Pilih Pengguna -</option>
                    @foreach($user as $item)
                        <option value="{{ $item->user_id }}" @selected($item->user_id == $stok->user_id)>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
                <small id="error-user_id" class="text-danger"></small>
            </div>

            <!-- Supplier -->
            <div class="form-group">
                <label>Supplier</label>
                <select class="form-control" name="supplier_id" required>
                    <option value="">- Pilih Supplier -</option>
                    @foreach($supplier as $item)
                        <option value="{{ $item->supplier_id }}" @selected($stok->supplier_id == $item->supplier_id)>
                            {{ $item->supplier_nama }}
                        </option>
                    @endforeach
                </select>
                <small id="error-supplier_id" class="text-danger"></small>
            </div>

            <!-- Tanggal -->
            <div class="form-group">
                <label>Tanggal Stok</label>
                <input type="datetime-local" name="stok_tanggal" class="form-control"
                    value="{{ \Carbon\Carbon::parse($stok->stok_tanggal)->format('Y-m-d\TH:i') }}" required>
                <small id="error-stok_tanggal" class="text-danger"></small>
            </div>

            <!-- Jumlah -->
            <div class="form-group">
                <label>Jumlah Stok</label>
                <input type="number" name="stok_jumlah" class="form-control" min="1"
                    value="{{ $stok->stok_jumlah }}" required>
                <small id="error-stok_jumlah" class="text-danger"></small>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

<script>
    $('#form-edit-stok').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function (response) {
                if (response.status) {
                    $('#myModal').modal('hide');
                    Swal.fire('Berhasil', response.message, 'success');
                    // reload datatable
                    dataStok.ajax.reload();
                } else {
                    $('.text-danger').text('');
                    $.each(response.msgField, function (key, value) {
                        $('#error-' + key).text(value[0]);
                    });
                    Swal.fire('Error', response.message, 'error');
                }
            }
        });
    });
</script>
