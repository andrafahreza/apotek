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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('no_pembelian');
            $table->unsignedBigInteger('pemasok_id');
            $table->unsignedBigInteger('obat_id');
            $table->integer('jumlah_obat');
            $table->bigInteger('total_bayar');
            $table->timestamps();

            $table->foreign("pemasok_id")->references("id")->on("pemasok");
            $table->foreign("obat_id")->references("id")->on("obat");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
