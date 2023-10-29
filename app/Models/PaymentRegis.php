<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRegis extends Model
{
    use HasFactory;

    protected $table = 'payment_regis';
    protected $fillable = [
        'number',
        'total_price',
        'payment_status',
        'snap_token'
    ];
}
