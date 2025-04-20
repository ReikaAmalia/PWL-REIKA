<form id="formImport" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Import Data Penjualan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Download Template</label><br>
            <a href="{{ url('template/template_penjualan.xlsx') }}" class="btn btn-sm btn-primary" target="_blank">
                <i class="fa fa-download"></i> Download
            </a>
        </div>
        <div class="form-group">
            <label for="file_penjualan">Pilih File</label>
            <input type="file" name="file_penjualan" id="file_penjualan" class="form-control" accept=".xlsx" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Upload</button>
    </div>
</form>

<script>
    $('#formImport').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "{{ url('penjualan/import_ajax') }}",
            method: "POST",
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function() {
                // tampilkan loading, disable tombol, dll
            },
            success: function(response) {
                if (response.status) {
                    alert(response.message);
                    $('#myModal').modal('hide');
                    $('#table_stok').DataTable().ajax.reload(); // reload data
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
    console.log(xhr.responseText);
    alert("Terjadi kesalahan saat mengupload file.");
}

        });
    });
</script>
