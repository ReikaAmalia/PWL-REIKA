<!DOCTYPE html>
<html>
<head>
    <title>Add Stock</title>
</head>
<body>
    <h1>Add Stock</h1>

    <form action="{{ route('stocks.store') }}" method="POST">
        @csrf <!-- Token CSRF untuk melindungi dari serangan CSRF -->

        <!-- Input untuk memasukkan nama stock dan wajib diisi -->
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <br>

        <!-- Input untuk memasukkan deskripsi stock dan wajib diisi -->
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <br>

        <!-- Untuk mengirimkan form dan menambahkan stoCk baru-->
        <button type="submit">Add Stock</button>
    </form>

    <!-- Untuk kembali pada halaman daftar stock -->
    <a href="{{ route('stocks.index') }}">Back to List</a>
</body>
</html>