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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('obat_id');
            $table->string('nomor_pembelian');
            $table->integer('jumlah_obat');
            $table->integer('total_bayar');
            $table->enum('pembayaran', ['cash', 'transfer'])->default('cash');
            $table->text('keterangan')->nullable();
            $table->enum('status_pembayaran', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->enum('status_pembelian', ['menunggu', 'sukses', 'gagal'])->default('menunggu');
            $table->string('bukti_transfer')->nullable();
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
        Schema::dropIfExists('penjualan');
    }
};
