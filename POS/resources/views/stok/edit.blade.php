@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Data Stok</h3>
        </div>
        <div class="card-body">
            @if (empty($stok))
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('stok') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('stok/'.$stok->stok_id) }}" class="form-horizontal">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Supplier</label>
                        <div class="col-md-10">
                            <select name="supplier_id" class="form-control" required>
                                <option value="">- Pilih Supplier -</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->supplier_id }}" 
                                        {{ $supplier->supplier_id == $stok->supplier_id ? 'selected' : '' }}>
                                        {{ $supplier->supplier_nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Barang</label>
                        <div class="col-md-10">
                            <select name="barang_id" class="form-control" required>
                                <option value="">- Pilih Barang -</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->barang_id }}" 
                                        {{ $barang->barang_id == $stok->barang_id ? 'selected' : '' }}>
                                        {{ $barang->barang_nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">User</label>
                        <div class="col-md-10">
                            <select name="user_id" class="form-control" required>
                                <option value="">- Pilih User -</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->user_id }}" 
                                        {{ $user->user_id == $stok->user_id ? 'selected' : '' }}>
                                        {{ $user->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Tanggal Stok</label>
                        <div class="col-md-10">
                            <input type="datetime-local" name="stok_tanggal" class="form-control"
                                value="{{ old('stok_tanggal', \Carbon\Carbon::parse($stok->stok_tanggal)->format('Y-m-d\TH:i')) }}" required>
                            @error('stok_tanggal')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Jumlah Stok</label>
                        <div class="col-md-10">
                            <input type="number" name="stok_jumlah" class="form-control" 
                                value="{{ old('stok_jumlah', $stok->stok_jumlah) }}" required>
                            @error('stok_jumlah')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a href="{{ url('stok') }}" class="btn btn-sm btn-default ml-1">Kembali</a>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
