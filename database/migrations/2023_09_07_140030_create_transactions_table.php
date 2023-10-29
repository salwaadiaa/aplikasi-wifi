<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::dropIfExists('transactions');

    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->char('id_pelanggan',10); // Kolom untuk Id Pelanggan
        $table->string('nama'); // Kolom untuk Nama
        $table->string('paket'); // Kolom untuk Nama Paket
        $table->string('abodemen'); // Kolom untuk Harga Paket (decimal dengan dua digit desimal)
        $table->integer('nominal'); // Kolom untuk Harga Paket (decimal dengan dua digit desimal)
        $table->date('tgl_trans'); // Kolom untuk Tanggal Bayar
        $table->enum('status', ['sudah bayar', 'menunggu pembayaran', 'kadaluarsa']); // Kolom untuk Tanggal Bayar
        $table->enum('status_transaksi', ['register', 'paket'])->default('register'); // Kolom untuk Tanggal Bayar
        $table->string('snap_token')->nullable(); // Kolom untuk Tanggal Bayar
        $table->string('order_id')->nullable(); // Kolom untuk Tanggal Bayar
        $table->timestamps();
        // Definisikan hubungan dengan tabel pelanggan (jika diperlukan)
        // $table->foreign('customer_id')->references('id_pelanggan')->on('data_pelanggans')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
