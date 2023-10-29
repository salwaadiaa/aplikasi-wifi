<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi Registrasi</title>
    <style>
        /* Gaya CSS untuk laporan PDF */
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #333;
            font-size: 24px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            border: 1px solid #ccc; /* Ganti warna batas dari #333 menjadi #ccc (silver) */
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Data Transaksi Registrasi</h1>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>Id Pelanggan</th>
                <th>Nama</th>
                <th>Paket</th>
                <th>Nominal Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->dataPelanggan->id_pelanggan }}</td>
                    <td>{{ $transaction->dataPelanggan->nama }}</td>
                    <td>{{ $transaction->getPaket->nama_paket }}</td>
                    <td>Rp {{ number_format($transaction->nominal, 0, ',', '.') }}</td>
                    <td>{{ $transaction->tgl_trans }}</td>
                    <td>{{ $transaction->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
