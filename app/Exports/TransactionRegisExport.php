<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionRegisExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil data transaksi yang sesuai dengan kebutuhan Anda
        $transactions = Transaction::whereIn('status_transaksi', ['register'])
            ->orderBy('id')
            ->with('dataPelanggan', 'getPaket')
            ->get();

        // Buat data yang akan diekspor ke dalam format yang sesuai
        $data = [];
        foreach ($transactions as $transaction) {
            $data[] = [
                $transaction->id,
                $transaction->dataPelanggan->id_pelanggan,
                $transaction->dataPelanggan->nama,
                $transaction->getPaket->nama_paket,
                $transaction->abodemen,
                $transaction->nominal,
                $transaction->tgl_trans,
                $transaction->status,
            ];
        }

        return collect($data);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'NO',
            'Id Pelanggan',
            'Nama',
            'Paket',
            'Abodemen',
            'Nominal Transaksi',
            'Tanggal Transaksi',
            'Status',
        ];
    }
}
