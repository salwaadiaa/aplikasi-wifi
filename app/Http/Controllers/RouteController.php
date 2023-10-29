<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggan;
use App\Models\Transaction;
use App\Services\Midtrans\CreateSnapTokenTransaksiService;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class RouteController extends Controller
{

    public function dashboard()
    {
        $tanggalSekarang = now('Asia/Jakarta')->format('Y-m-d');
        $dataPelangganBelumBayarPaket = DataPelanggan::where('tgl_bayar', '<=', $tanggalSekarang)
            ->when(auth()->user()->role == 'user', function ($query) {
                return $query->where('user_id', auth()->user()->id);
            })
            ->get();
            $noWaPelangganBelumBayarPaket = $dataPelangganBelumBayarPaket->pluck(['telp'])->unique()->toArray();
            $namaWaPelangganBelumBayarPaket = $dataPelangganBelumBayarPaket->pluck(['nama'])->unique()->toArray();

            $phoneNumbers = [];

            foreach ($noWaPelangganBelumBayarPaket as $key => $noWa) {
                $phoneNumbers[] = $noWa . '|' . $namaWaPelangganBelumBayarPaket[$key];
            }

            $tglBayarPelanggan = $dataPelangganBelumBayarPaket->pluck('tgl_bayar')->unique()->toArray();
            $payloadNewTransaction = [];

            foreach ($dataPelangganBelumBayarPaket as $key => $pelanggan) {
                // Cek apakah transaksi sudah ada
                $existingTransaction = Transaction::where('id_pelanggan', $pelanggan->id_pelanggan)
                    ->where('status_transaksi', 'paket')
                    ->where('status', 'menunggu pembayaran')
                    ->first();

                if (!$existingTransaction) {
                    $midtrans = new CreateSnapTokenTransaksiService($pelanggan);
                    $orderId = 'PAKET-' . sprintf('%04d', rand(0000, 9999) + 1);

                    $payloadNewTransaction[] = [
                        'id_pelanggan' => $pelanggan->id_pelanggan,
                        'nama' => $pelanggan->nama,
                        'paket' => $pelanggan->getPaket->id,
                        'abodemen' => $pelanggan->abodemen,
                        'nominal' => $pelanggan->abodemen,
                        'tgl_trans' => $tglBayarPelanggan[$key],
                        'status' => 'menunggu pembayaran',
                        'status_transaksi' => 'paket',
                        'snap_token' => $midtrans->getSnapToken($orderId),
                        'order_id' => $orderId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            foreach ($payloadNewTransaction as $key => $value) {
                $phoneNumbers[$key] = $phoneNumbers[$key] . '|' . $value['snap_token'];
            }

            if (!empty($payloadNewTransaction)) {
                Transaction::insert($payloadNewTransaction);
                $client = new Client();
                $token = config('app.fonnte_token'); // Ganti dengan token Anda

                try {
                    $response = $client->post('https://api.fonnte.com/send', [
                        'headers' => [
                            'Authorization' => $token,
                        ],
                        'form_params' => [
                            'target' => implode(',', $phoneNumbers),
                            'message' => "Halo {name},\n\n kami dari PT. SAZ mengingatkan bahwa anda belum membayar paket internet anda. Silahkan segera melakukan pembayaran. Terima kasih.\n\n Klik link berikut untuk melakukan pembayaran: https://app.sandbox.midtrans.com/snap/v3/redirection/{var1}",
                        ],
                    ]);

                    // Handle response if needed
                    $responseBody = $response->getBody()->getContents();

                    // Show response to console
                    echo $responseBody;
                } catch (\Exception $e) {
                    // Handle exception if the request fails
                    // Log::error($e->getMessage());

                    // Show error message to console
                    echo $e->getMessage();
                }
            }

        // $client = new Client();
        // $response = $client->request('GET', 'https://api.sandbox.midtrans.com/v2/REGIS-1176/status', [
        //     'headers' => [
        //         'accept' => 'application/json',
        //         'authorization' => 'Basic U0ItTWlkLXNlcnZlci1sMXlBYVdZN0lWeE9talJDOTNOTUtDenk6',
        //     ],
        // ]);

        // $response = json_decode($response->getBody()->getContents(), true);
        // dd($response);

        return view('dashboard.index', compact('dataPelangganBelumBayarPaket'));
    }
}
