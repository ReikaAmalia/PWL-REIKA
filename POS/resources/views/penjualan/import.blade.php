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
    $(document).ready(function() {
        $("#form-import").validate({
            rules: {
                file_level: {required: true, extension: "xlsx"},
            },
            submitHandler: function(form) {
                var formData = new FormData(form); // Jadikan form ke FormData untuk menghandle file
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData, // Data yang dikirim berupa FormData
                    processData: false, // setting processData dan contentType ke false, untuk menghandle file
                    contentType: false,
                    success: function(response) {
                        if(response.status){ // jika sukses
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            tableLevel.ajax.reload(); // reload datatable
                        }else{ // jika error
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-'+prefix).text(val[0]);
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
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            }
        });
    });
</script>