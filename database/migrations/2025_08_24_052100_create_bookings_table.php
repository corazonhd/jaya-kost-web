<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kamar_dipilih');
            $table->string('nama');
            $table->string('telepon');
            $table->string('email')->nullable();
            $table->date('tanggal_masuk');
            $table->integer('durasi_sewa');
            $table->decimal('harga', 10, 2);
            $table->string('invoice_id')->nullable();
            $table->string('status_pembayaran')->default('PENDING');
            $table->string('jenis_pembayaran');
            $table->decimal('jumlah_bayar', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}