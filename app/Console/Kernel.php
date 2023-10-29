<?php

namespace App\Console;

use App\Models\DataPelanggan;
use App\Models\Transaction;
use App\Services\Midtrans\CreateSnapTokenTransaksiService;
use GuzzleHttp\Client;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $tanggalSekarang = now('Asia/Jakarta')->format('Y-m-d');
            $dataPelangganBelumBayarPaket = DataPelanggan::where('tgl_bayar', '<=', $tanggalSekarang)
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
        })->everyMinute();
        // })->dailyAt('08:00')->timezone('Asia/Jakarta');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
