<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiTiang extends Model
{
    use HasFactory;
    protected $table = 'lokasi_tiangs';
    protected $fillable = [
        'nama_box',
        'provinsi',
        'kota',
        'kode_pos',
        'alamat'
    ];
}
