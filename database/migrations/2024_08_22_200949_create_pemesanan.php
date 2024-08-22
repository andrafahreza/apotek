<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('obat_id');
            $table->enum('status', ['menunggu', 'diterima', 'ditolak']);
            $table->integer('jumlah');
            $table->integer('harga');
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("obat_id")->references("id")->on("obat");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
