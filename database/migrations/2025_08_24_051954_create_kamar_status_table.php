<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKamarStatusTable extends Migration
{
    public function up()
    {
        Schema::create('kamar_status', function (Blueprint $table) {
            $table->string('nama_kamar', 10)->primary();
            $table->string('status', 20)->default('Available');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kamar_status');
    }
}