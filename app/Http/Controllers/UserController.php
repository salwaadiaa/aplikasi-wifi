<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentRegis;
use App\Models\Transaction;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = DataPelanggan::where('status', 'belum dikonfirmasi')
            ->orderByDesc('id')
            ->paginate(10);

        foreach ($users as $user) {
            if(!$user->snap_token){
                $midtrans = new CreateSnapTokenService($user);
                $snapToken = $midtrans->getSnapToken();

                $user->snap_token = $snapToken;
                $user->save();
            }
        }

        return view('dashboard.data-pendaftar.index', compact('users'));
    }

    public function update($id)
    {
        $user = DataPelanggan::find($id);

        if ($user) {
            $user->status = 'berlangganan';
            $user->tgl_join = now('Asia/Jakarta');
            $user->tgl_bayar = now('Asia/Jakarta')->addMonth();
            $user->snap_token = null;
            $user->save();

            $paket = $user->getPaket;

            if ($paket) {
                Transaction::create([
                    'id_pelanggan' => $user->id_pelanggan,
                    'nama' => $user->nama,
                    'paket' => $paket->id,
                    'abodemen' => $paket->abodemen,
                    'nominal' => 150000,
                    'tgl_trans' => now(),
                    'status' => 'sudah bayar',
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil di konfirmasi',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Paket tidak ditemukan',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data pelanggan tidak ditemukan',
            ]);
        }
    }

    public function bayarPaket($id, $orderId)
    {
        $user = DataPelanggan::whereUserId($id)->first();

        if ($user) {

            $transaction = Transaction::where('order_id', $orderId)->first();

            if ($transaction) {
                $transaction->update([
                    'status' => 'sudah bayar',
                    'snap_token' => null,
                    'updated_at' => now(),
                ]);

                $user->update([
                    'status' => 'berlangganan',
                    'tgl_bayar' => Carbon::parse($user->tgl_bayar)->addMonth(),
                    'snap_token' => null,
                    'updated_at' => now(),
                ]);
                $phoneNumber = $user->telp . '|' . $user->nama;
                $client = new Client();
                try {
                    $response = $client->post('https://api.fonnte.com/send', [
                        'headers' => [
                            'Authorization' => config('app.fonnte_token'),
                        ],
                        'form_params' => [
                            'target' => $phoneNumber,
                            'message' => " Halo {name},\n\n kami dari SAZ.Net pembayaran paket internet anda telah kami terima. Terima kasih telah mempercayai kami.\n\n Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami. Terima kasih juga karena telah mempercayai kami.",
                        ],
                    ]);

                    // Handle response if needed
                    $responseBody = $response->getBody()->getContents();

                    // Show response to console
                } catch (\Exception $e) {
                    // Handle exception if the request fails
                    Log::error($e->getMessage());

                    // Show error message to console
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Paket berhasil dibayar',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Paket tidak ditemukan',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data pelanggan tidak ditemukan',
            ]);
        }
    }

    public function destroy($id)
    {
        $user = DataPelanggan::findOrFail($id);
        $user->delete();

        return redirect(route('data-pendaftar.index'))->with('success', 'Data Pendaftar telah dihapus');
    }

    public function pdf($id)
    {
        $user = DataPelanggan::findOrFail($id);
        $data = [
            'user' => $user,
        ];
        $pdf = Pdf::loadView('dashboard.data-pendaftar.generate_pdf', $data);
        return $pdf->stream();
    }

    public function sendNotif($wa, Request $request)
    {
        // Ambil nomor WhatsApp pelanggan dari parameter $wa
        $nomorWhatsAppTujuan = $wa;

        // Nomor WhatsApp admin (nomor pengirim)
        $nomorWhatsAppAdmin = '6288214329439'; // Gantilah ini dengan nomor WhatsApp admin Anda yang dimulai dengan "62"

        // Validasi: Pastikan nomor WhatsApp admin dimulai dengan "62"
        if (substr($nomorWhatsAppAdmin, 0, 2) !== '62') {
            return redirect()->back()->with('error', 'Nomor WhatsApp admin harus dimulai dengan "62".');
        }

        // Validasi: Pastikan nomor WhatsApp tujuan bukan nomor WhatsApp admin
        if ($nomorWhatsAppTujuan === $nomorWhatsAppAdmin) {
            return redirect()->back()->with('error', 'Tidak dapat mengirim pesan ke nomor admin.');
        }

        // Ambil data pengguna berdasarkan nomor WhatsApp
        $user = DataPelanggan::where('telp', $wa)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Data pendaftar tidak ditemukan.');
        }

        $namaPendaftar = $user->nama; // Ambil nama pendaftar dari database
        $alamatPendaftar = $user->alamat;

        $alamatPendaftar = "*$alamatPendaftar*";

        // Buat pesan yang ingin Anda kirim
        $pesan = "Halo $namaPendaftar,\n\nKami ingin memberitahu Anda bahwa kami telah mengkonfirmasi pendaftaran Anda. Terima kasih atas kepercayaan Anda kepada kami. Kami akan segera memproses untuk pemasangan lebih lanjut dan memberikan layanan terbaik kepada Anda.\n\nApakah alamat berikut ini sudah benar?\n$alamatPendaftar\n\nJika alamat yang tertera sudah benar, teknisi kami akan segera melakukan survei untuk pemasangan ke alamat yang tersedia di atas.\n\n Berikut Juga kami kirimkan no virtual akun untuk melanjutkan transaksi, berikut adalah nomornya: \n\n $request->va - bank virtual account BCA \n\nJika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami. Terima kasih juga karena telah mempercayai kami.";

        // Kirim pesan

        $response = $this->sendWhatsAppMessage($nomorWhatsAppTujuan, $pesan);

        // Ubah status pendaftar menjadi 'sudah dikonfirmasi'
        if(!$request->get('amp;settlement') == 'pending'){
            $user->status = 'sudah dikonfirmasi';
            $user->update();
        }

        session()->flash('konfirmasi_status', 'Pendaftar telah dikonfirmasi.');

        // Redirect pengguna ke link WhatsApp
        return back()->with('success', 'Pendaftar telah berhasil dikonfirmasi');
    }

    public function sendWhatsAppMessage($target, $message)
    {
        $client = new Client();
        $token = '@Simk6etHuemH!CSz0+d'; // Ganti dengan token Anda

        try {
            $response = $client->post('https://api.fonnte.com/send', [
                'headers' => [
                    'Authorization' => $token,
                ],
                'form_params' => [     
                    'target' => $target,
                    'message' => $message,
                ],
            ]);

            // Handle response if needed
            $responseBody = $response->getBody()->getContents();

            // Show response to console
            return $responseBody;
        } catch (\Exception $e) {
            // Handle exception if the request fails
            // Log::error($e->getMessage());

            // Show error message to console
            return $e->getMessage();
        }
    }
}
