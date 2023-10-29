<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return collect($this->transactions);
    }

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

    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->id_pelanggan,
            $transaction->nama,
            $transaction->getPaket->nama_paket,
            $transaction->abodemen,
            $transaction->nominal,
            $transaction->tgl_trans,
            $transaction->status,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply borders to the entire table
        $tableRange = 'A1:H' . (count($this->transactions) + 1);
        $sheet->getStyle($tableRange)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
    }
}
