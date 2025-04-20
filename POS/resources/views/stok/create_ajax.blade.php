<form id="form-tambah" method="POST" action="{{ url('/stok/store_ajax') }}">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Form Tambah Data Stok</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    
    <div class="modal-body">
        <div class="form-group">
            <label>Supplier</label>
            <select name="supplier_id" class="form-control">
                <option value="">-- Pilih Supplier --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_nama }}</option>
                @endforeach
            </select>
            <small class="text-danger error-text" id="error-supplier_id"></small>
        </div>

        <div class="form-group">
            <label>Barang</label>
            <select name="barang_id" class="form-control">
                <option value="">-- Pilih Barang --</option>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->barang_id }}">{{ $barang->barang_nama }}</option>
                @endforeach
            </select>
            <small class="text-danger error-text" id="error-barang_id"></small>
        </div>

        <div class="form-group">
            <label>User</label>
            <select name="user_id" class="form-control">
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->user_id }}">{{ $user->nama }}</option>
                @endforeach
            </select>
            <small class="text-danger error-text" id="error-user_id"></small>
        </div>

        <div class="form-group">
            <label>Tanggal Stok</label>
            <input type="date" name="stok_tanggal" class="form-control">
            <small class="text-danger error-text" id="error-stok_tanggal"></small>
        </div>

        <div class="form-group">
            <label>Jumlah Stok</label>
            <input type="number" name="stok_jumlah" class="form-control">
            <small class="text-danger error-text" id="error-stok_jumlah"></small>
        </div>
    </div>
    
    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
    </div>
</form>
