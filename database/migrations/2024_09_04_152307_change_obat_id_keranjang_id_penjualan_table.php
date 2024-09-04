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
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropForeign(['obat_id']);
            $table->dropColumn('obat_id');
            $table->dropColumn('jumlah_obat');
            $table->dropColumn('total_bayar');
            $table->unsignedBigInteger('keranjang_id')->after('user_id');

            $table->foreign("keranjang_id")->references("id")->on("keranjang");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
