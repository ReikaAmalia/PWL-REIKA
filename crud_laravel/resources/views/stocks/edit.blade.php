<!DOCTYPE html>
<html>
<head>
    <title>Edit Stock</title>
</head>
<body>
    <h1>Edit Stock</h1>

    <form action="{{ route('stocks.update', $stock) }}" method="POST">
        @csrf
        @method('PUT') <!-- Mengubah metode form menjadi PUT untuk update data -->

        <!-- Input untuk mengedit nama stok dan nilai default diambil dari data stock yang ada -->
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $stock->name }}" required>
        <br>

        <!-- Untuk mengedit deskripsi stock dan nilai default diambil dari data stock yang ada -->
        <label for="description">Description:</label>
        <textarea name="description" required>{{ $stock->description }}</textarea>
        <br>

        <!-- Untuk mengirimkan form dan memperbarui stock -->
        <button type="submit">Update Stock</button>
    </form>

    <!-- Link untuk kembali pada halaman daftar stock -->
    <a href="{{ route('stocks.index') }}">Back to List</a>
</body>
</html>