<?php

namespace Database\Seeders;

use App\Models\Paket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pakets = [
            [
                'nama_paket' => 'Paket Entry',
                'paket' => '5 MB',
                'abodemen' => '160000',
            ],
            [
                'nama_paket' => 'Paket Basic',
                'paket' => '7 MB',
                'abodemen' => '180000',
            ],
            [
                'nama_paket' => 'Paket Silver',
                'paket' => '10 MB',
                'abodemen' => '220000',
            ],            
            [
                'nama_paket' => 'Paket Gold',
                'paket' => '20 MB',
                'abodemen' => '280000',
            ],
            [
                'nama_paket' => 'Paket Platinum',
                'paket' => '30 MB',
                'abodemen' => '320000',
            ],  
            [
                'nama_paket' => 'Paket Extra Platinum',
                'paket' => '50 MB',
                'abodemen' => '450000',
            ],         
        ];

        Paket::insert($pakets);
    }
}
