<!DOCTYPE html>
<html>
<head>
    <title>Stock List</title>
</head>
<body>
    <h1>Stocks</h1>

    <!-- untuk menampilkan pesan sukses jika ada session dengan kata kunci 'success' -->
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

<!-- Link ini untuk menambahkan stock yang baru -->
    <a href="{{ route('stocks.create') }}">Add Stock</a>

    <ul>
        <!-- Pengulangan melalui semua data stock yang diterima dari controller -->
        @foreach ($stocks as $stock) 
            <li>
                {{ $stock->name }} - <!-- Menampilkan nama stock -->
                <a href="{{ route('stocks.edit', $stock) }}">Edit</a> <!-- Link edit stock yang dipilih -->
                <form action="{{ route('stocks.destroy', $stock) }}" method="POST" style="display:inline;"> <!-- form menghapus stock yang dipilih -->
                    @csrf <!-- token CSRF untuk melindungi dari serangan CSRF -->
                    @method('DELETE') <!-- Mengubah metode form menjadi delete -->
                    <button type="submit">Delete</button> <!-- Tombol untuk menghapus stock -->
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>