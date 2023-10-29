<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>SAZ.Net</title>
  <style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .centered-title {
        text-align: center;
    }

    table {
        width: 100%;
    }
</style>
<body>
    <table>
        <tr>
            <td colspan="3" class="centered-title">
                <h3>Data Pendaftar</h3>
            </td>
        </tr>
        <tr>
            <td>ID Pendaftar</td>
            <td>:</td>
            <td>{{ $user->id_pelanggan }}</td>
        </tr>
        <tr>
            <td>Nama Pendaftar</td>
            <td>:</td>
            <td>{{ $user->nama }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <td>Nomor Telepon</td>
            <td>:</td>
            <td>{{ $user->telp }}</td>
        </tr>
        <tr>
            <td>Provinsi</td>
            <td>:</td>
            <td>{{ $user->provinsi }}</td>
        </tr>
        <tr>
            <td>Kota</td>
            <td>:</td>
            <td>{{ $user->kota }}</td>
        </tr>
        <tr>
            <td>Kode Pos</td>
            <td>:</td>
        <td>{{ $user->kode_pos }}</td>
    </tr>
    <tr>
        <td>Alamat Lengkap</td>
        <td>:</td>
        <td>{{ $user->alamat }}</td>
    </tr>
    <tr>
        <td>Paket</td>
        <td>:</td>
        <td>{{ $user->paket }}</td>
    </tr>
    <tr>
        <td>Abodemen</td>
        <td>:</td>
        <td>{{ $user->abodemen }}</td>
    </tr>
</table>
</body>
</html>
