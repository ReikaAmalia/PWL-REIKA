<!DOCTYPE html>
<html>
<head>
    <title>Stock List</title>
</head>
<body>
    <h1>Stocks</h1>
    <!-- Untuk menampilkan pesan sukses jika ada kata kunci kunci 'success' -->
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <!-- Untuk menambahkan stock baru -->
    <a href="{{ route('stocks.create') }}">Add Stock</a>

    <ul>
        <!--  Pengulangan untuk data stock yang diterima dari controller -->
        @foreach ($stocks as $stock)
            <li>
                {{ $stock->name }} -
                <!-- Untuk mengedit stok yang dipilih -->
                <a href="{{ route('stocks.edit', $stock) }}">Edit</a>

                <!-- Untuk menghapus stok yang dipilih -->
                <form action="{{ route('stocks.destroy', $stock) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE') <!-- mengubah form menjadi delete untuk proses hapus -->
                    <button type="submit">Delete</button> <!-- tombol untuk menghapus stock -->
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>