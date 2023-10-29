<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\IOFactory;
use App\Models\DataPelanggan;
use App\Http\Requests\RequestStoreOrUpdateTransaction;
use Carbon\Carbon;
use App\Exports\TransactionExport;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return view('dashboard.transaksi.index', compact('transactions'));
    }

    public function bayar()
    {
        $confirmedUsers = DataPelanggan::whereIn('status', ['berlangganan', 'diputus sementara'])->get();
        $defaultStatus = 'sudah bayar'; // Set the default status here

        return view('dashboard.transaksi.bayar', compact('confirmedUsers', 'defaultStatus'));
    }
    public function generatePDF()
{
    $transactions = Transaction::all();

    $pdf = PDF::loadView('dashboard.transaksi.generate_pdf', compact('transactions'));

     // Simpan laporan sebagai file PDF
     $filename = 'transaksi paket.pdf';
     $pdf->save(storage_path($filename));

     // Kembalikan laporan sebagai respons
     return response()->download(storage_path($filename))->deleteFileAfterSend(true);
}

public function generateExcel()
{
    $transactions = Transaction::all();

    return Excel::download(new TransactionExport($transactions), 'transaksi paket.xlsx');
}

public function generateWord()
{
    $transactions = Transaction::all();

    // Create a new PhpWord instance
    $phpWord = new PhpWord();

    // Add a section to the document
    $section = $phpWord->addSection();

    // Add a title
    $section->addText('Laporan Transaksi', ['bold' => true]);

    // Create a table
    $table = $section->addTable();
    
    // Define cell width (adjust as needed)
    $cellWidth = 2000;

    // Add table headers
    $table->addRow();
    $table->addCell($cellWidth)->addText('NO');
    $table->addCell($cellWidth)->addText('Id Pelanggan');
    $table->addCell($cellWidth)->addText('Nama');
    $table->addCell($cellWidth)->addText('Paket');
    $table->addCell($cellWidth)->addText('Abodemen');
    $table->addCell($cellWidth)->addText('Nominal Transaksi');
    $table->addCell($cellWidth)->addText('Tanggal Transaksi');
    $table->addCell($cellWidth)->addText('Status');

    // Extract data from the HTML table
    foreach ($transactions as $transaction) {
        $table->addRow();
        $table->addCell($cellWidth)->addText($transaction->id);
        $table->addCell($cellWidth)->addText($transaction->id_pelanggan);
        $table->addCell($cellWidth)->addText($transaction->nama);
        $table->addCell($cellWidth)->addText($transaction->getPaket->nama_paket);
        $table->addCell($cellWidth)->addText($transaction->abodemen);
        $table->addCell($cellWidth)->addText($transaction->nominal);
        $table->addCell($cellWidth)->addText($transaction->tgl_trans);
        $table->addCell($cellWidth)->addText($transaction->status);
    }

    // Save the Word document to a file
    $filename = 'transaksi paket.docx';
    $phpWord->save(storage_path($filename));

    // Return the Word document as a response
    return response()->download(storage_path($filename))->deleteFileAfterSend(true);
}

public function store(Request $request)
{
// Validasi data dengan request
$validatedData = $request->all();

// Dapatkan data pelanggan yang sesuai dengan 'id_pelanggan'
$dataPelanggan = DataPelanggan::find($validatedData['id_pelanggan']);


// Membuat data transaksi dengan menggunakan data pelanggan
$transaction = new Transaction([
    'id_pelanggan' => $dataPelanggan->id_pelanggan,
    'nama' => $dataPelanggan->nama,
    'paket' => $dataPelanggan->paket,
    'abodemen' => $dataPelanggan->abodemen,
    'nominal' => $dataPelanggan->getPaket->abodemen,
    'status' => $validatedData['status'],
    'status_transaksi' => 'paket',
    'tgl_trans' => $validatedData['tgl_trans'],
]);
$dataPelanggan->tgl_bayar = Carbon::parse($dataPelanggan->tgl_bayar)->addMonth();

$dataPelanggan->save();
$transaction->save();



    return redirect(route('transaksi.index'))->with('success', 'Transaksi berhasil ditambahkan.');
}

}
