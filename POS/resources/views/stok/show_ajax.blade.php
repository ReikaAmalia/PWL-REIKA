<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Detail Data Stok</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <table class="table table-bordered">
            <tr><th>Barang</th><td>{{ $stok->barang->barang_nama }}</td></tr>
            <tr><th>Supplier</th><td>{{ $stok->supplier->supplier_nama }}</td></tr>
            <tr><th>User</th><td>{{ $stok->user->nama }}</td></tr>
            <tr><th>Tanggal</th><td>{{ \Carbon\Carbon::parse($stok->stok_tanggal)->format('d-m-Y H:i') }}</td></tr>
            <tr><th>Jumlah</th><td>{{ $stok->stok_jumlah }}</td></tr>
        </table>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
    </div>
</div>
