<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\DataPelanggan;
use App\Http\Requests\RequestStoreOrUpdateTransaction;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use App\Exports\TransactionRegisExport;

use Illuminate\Http\Request;

class TransactionRegisController extends Controller
{
    public function index(Request $request)
{
    // Ambil filter dari permintaan
    $filter = $request->input('period_filter');

    // Query berdasarkan filter
    $transactions = Transaction::whereIn('status_transaksi', ['register'])
        ->when($filter, function ($query) use ($filter) {
            if ($filter === 'day') {
                $query->whereDate('tgl_trans', today());
            } elseif ($filter === 'week') {
                $query->whereBetween('tgl_trans', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($filter === 'year') {
                $query->whereYear('tgl_trans', now()->year);
            }
        })
        ->orderBy('id')
        ->with('dataPelanggan', 'getPaket')
        ->paginate(5);

    return view('dashboard.transaksi-regis.index', compact('transactions'));
}


    public function bayar()
    {
        $confirmedUsers = DataPelanggan::where('status', 'sudah dikonfirmasi')->get();
        $defaultStatus = 'sudah bayar'; // Set the default status here

        return view('dashboard.transaksi-regis.bayar', compact('confirmedUsers', 'defaultStatus'));
    }

    public function store(RequestStoreOrUpdateTransaction $request)
    {
    // Validasi data dengan request
    $validatedData = $request->validated();

    // Dapatkan data pelanggan yang sesuai dengan 'id_pelanggan'
    $dataPelanggan = DataPelanggan::find($validatedData['id_pelanggan']);

    // Membuat data transaksi dengan menggunakan data pelanggan
    $transaction = new Transaction([
        'id_pelanggan' => $validatedData['id_pelanggan'],
        'nama' => $dataPelanggan->nama,
        'paket' => $dataPelanggan->paket,
        'abodemen' => 0,
        'nominal' => $validatedData['nominal'],
        'status' => $validatedData['status'],
        'tgl_trans' => $validatedData['tgl_trans'],
    ]);

    $transaction->save();



        return redirect(route('transaksi-regis.index'))->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function printPdf()
{
    $transactions = Transaction::whereIn('status_transaksi', ['register'])
    ->orderBy('id')
    ->with('dataPelanggan', 'getPaket')
    ->get();

$pdf = PDF::loadView('dashboard.transaksi-regis.pdf', compact('transactions'));

// Simpan laporan sebagai file PDF
$filename = 'transaksi regis.pdf';
$pdf->save(storage_path($filename));

// Kembalikan laporan sebagai respons
return response()->download(storage_path($filename))->deleteFileAfterSend(true);
}

public function downloadExcel()
{
    // Ambil data transaksi-regis yang diperlukan
    $transactions = Transaction::whereIn('status_transaksi', ['register'])
        ->orderBy('id')
        ->with('dataPelanggan', 'getPaket')
        ->get();

    // Ekspor data ke format Excel menggunakan library Maatwebsite/Excel
    return Excel::download(new TransactionRegisExport($transactions), 'transaksi regis.xlsx');
}

public function downloadWord()
{
    // Ambil data transaksi-regis yang diperlukan
    $transactions = Transaction::whereIn('status_transaksi', ['register'])
        ->orderBy('id')
        ->with('dataPelanggan', 'getPaket')
        ->get();

    // Buat objek PhpWord
    $phpWord = new PhpWord();

    // Tambahkan halaman baru
    $section = $phpWord->addSection();

    // Tambahkan judul
    $section->addText('Laporan Transaksi Registrasi', ['bold' => true]);

    // Tambahkan tabel
    $table = $section->addTable();
    $table->addRow();
    $table->addCell(200)->addText('NO');
    $table->addCell(2000)->addText('Id Pelanggan');
    $table->addCell(2000)->addText('Nama');
    $table->addCell(2000)->addText('Paket');
    $table->addCell(2000)->addText('Abodemen');
    $table->addCell(2000)->addText('Nominal Transaksi');
    $table->addCell(2000)->addText('Tanggal Transaksi');

    // Tambahkan data transaksi ke tabel
    foreach ($transactions as $transaction) {
        $table->addRow();
        $table->addCell(200)->addText($transaction->id);
        $table->addCell(2000)->addText($transaction->id_pelanggan);
        $table->addCell(2000)->addText($transaction->nama);
        $table->addCell(2000)->addText($transaction->getPaket->nama_paket);
        $table->addCell(2000)->addText($transaction->abodemen);
        $table->addCell(2000)->addText($transaction->nominal);
        $table->addCell(2000)->addText($transaction->tgl_trans);
    }

    // Simpan laporan sebagai file Word
    $filename = 'transaksi regis.docx';
    $phpWord->save(storage_path($filename));

    // Kembalikan laporan sebagai respons
    return response()
        ->download(storage_path($filename))
        ->deleteFileAfterSend(true);
}

    

}
