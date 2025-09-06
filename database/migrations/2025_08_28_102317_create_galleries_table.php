<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('blok');
            $table->string('image_url');
            $table->integer('order_index')->default(0);
            $table->timestamps();
            $table->string('public_id')->nullable()->after('image_url');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
