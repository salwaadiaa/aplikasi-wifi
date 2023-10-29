<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'nama' => 'master admin',
                'email' => 'masteradmin@mail.com',
                'telp' => '0895330909589',
                'password' => Hash::make('password'),
                'role' => 'masteradmin',
            ],
            [
                'nama' => 'admin',
                'email' => 'admin@mail.com',
                'telp' => '083803246357',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'nama' => 'teknisi',
                'email' => 'teknisi@mail.com',
                'telp' => '081234567890',
                'password' => Hash::make('password'),
                'role' => 'teknisi',
            ],
        ];

        User::insert($users);
    }
}
