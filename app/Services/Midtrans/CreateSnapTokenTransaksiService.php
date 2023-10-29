<?php

namespace App\Services\Midtrans;

use GuzzleHttp\Client;
use Midtrans\Snap;

class CreateSnapTokenTransaksiService extends Midtrans
{
    protected $pelanggan;

    public function __construct($pelanggan)
    {
        parent::__construct();

        $this->pelanggan = $pelanggan;
    }

    public function getSnapToken($orderId)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $this->pelanggan->getPaket->abodemen,
            ],
            'item_details' => [
                [
                    'id' => 1,
                    'price' => $this->pelanggan->getPaket->abodemen,
                    'quantity' => 1,
                    'name' => 'Pembayaran biaya registrasi WIFI SAZ',
                ],
            ],
            'customer_details' => [
                'first_name' => $this->pelanggan->nama,
                'email' => $this->pelanggan->email,
                'phone' => $this->pelanggan->telp,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
