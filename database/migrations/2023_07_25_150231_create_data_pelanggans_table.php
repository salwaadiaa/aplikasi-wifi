<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_pelanggans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->char('id_pelanggan', 10)->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('telp');
            $table->text('alamat');
            $table->date('tgl_join')->nullable();
            $table->string('paket');
            $table->float('abodemen');
            $table->date('tgl_bayar')->nullable();
            $table->string('foto_ktp');
            $table->string('provinsi');
            $table->string('kota');
            $table->integer('kode_pos');
            $table->enum('status', ['belum dikonfirmasi', 'sudah dikonfirmasi', 'berlangganan', 'diputus sementara', 'berhenti berlangganan'])->nullable();
            // $table->string('longitude');
            // $table->string('latitude');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_pelanggans');
    }
};
