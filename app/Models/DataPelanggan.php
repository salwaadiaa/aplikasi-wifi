<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Paket;
use Carbon\Carbon;

class DataPelanggan extends Model
{
    use HasFactory;

    protected $table = 'data_pelanggans';
    protected $fillable = [
        'user_id',
        'id_pelanggan',
        'email',
        'nama',
        'telp',
        'alamat',
        'tgl_join',
        'paket',
        'abodemen',
        'tgl_bayar',
        'foto_ktp',
        'provinsi',
        'kota',
        'kode_pos',
        'status',
        // 'longitude',
        // 'latitude',
    ];

   public function user()
   {
    return $this->belongsTo(User::class, 'user_id');
   }

   public function getPaket()
   {
    return $this->belongsTo(Paket::class, 'paket');
   }

   public function transactions()
   {
    return $this->hasMany(Transaction::class, 'id_pelanggan', 'id_pelanggan');
   }

//    protected static function boot()
//    {
//     Parent::boot();
//     static::creating(function($dataPelanggan) {
//         $dataPelanggan->tgl_join = Carbon::now();
//         $dataPelanggan->tgl_bayar = Carbon::now();
//     });
//    }

   public function setTelpAttribute($telp)
    {
        $cleanedPhoneNumber = str_replace([' ', '-', '+'], '', $telp);

        if (substr($cleanedPhoneNumber, 0, 1) === '0') {
            $formattedPhoneNumber = '62' . substr($cleanedPhoneNumber, 1);
        } else {
            $formattedPhoneNumber = $cleanedPhoneNumber;
        }

        $this->attributes['telp'] = $formattedPhoneNumber;
    }
}
