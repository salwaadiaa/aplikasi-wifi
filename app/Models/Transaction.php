<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DataPelanggan;
use App\Models\Paket;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $fillable = [
        'id_pelanggan', // Kolom untuk Id Pelanggan
        'nama', // Kolom untuk Nama
        'paket', // Kolom untuk Nama Paket
        'abodemen', // Kolom untuk Harga Paket
        'nominal', // Kolom untuk Harga Paket
        'tgl_trans', // Kolom untuk Tanggal Bayar
        'status', // Kolom untuk Tanggal Bayar
        'status_transaksi', // Kolom untuk Tanggal Bayar,
        'snap_token',
        'order_id',
        // Tambahkan kolom-kolom lain yang sesuai kebutuhan
    ];

    // Definisi relasi atau metode lainnya jika diperlukan
    public function dataPelanggan()
    {
        return $this->belongsTo(DataPelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function getPaket()
    {
        return $this->belongsTo(Paket::class, 'paket');
    }
}

