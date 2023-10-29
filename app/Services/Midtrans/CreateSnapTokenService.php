<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $order;

    public function __construct($order)
    {
        parent::__construct();

        $this->order = $order;
    }

    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id' => 'REGIS-' . sprintf('%04d', rand(0000, 9999)+ 1),
                'gross_amount' => 150000,
            ],
            'item_details' => [
                [
                    'id' => 1,
                    'price' => '150000',
                    'quantity' => 1,
                    'name' => 'Pembayaran biaya registrasi WIFI SAZ',
                ],
            ],
            'customer_details' => [
                'first_name' => $this->order->nama,
                'email' => $this->order->email,
                'phone' => $this->order->telp,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
