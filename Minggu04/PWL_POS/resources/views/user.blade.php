{{-- <!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>
    <h1>Profil Pengguna</h1>
    <p>ID: {{ $id }}</p>
    <p>Nama: {{ $name }}</p>
</body>
</html> --}}

{{-- jb 3 --}}
<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>
    <h1>Data User</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th>
        </tr> 
        {{-- @foreach ($data as $d) --}}
        <tr>
            <td>{{ $data->user_id }}</td>
            <td>{{ $data->username }}</td>
            <td>{{ $data->nama }}</td>
            <td>{{ $data->level_id }}</td>
        </tr>
        {{-- @endforeach --}}


        {{-- percobaan 2.3 jb 4 --}}
        {{-- <tr>
            <th>Jumlah Pengguna</th>
        </tr>
        <tr>
            <td>{{ $jumlahPengguna }}</td>
        </tr> --}}
    </table>
</body>
</html>