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
        Schema::table('keranjang_obat', function (Blueprint $table) {
            $table->integer('kuantiti')->after('obat_id');
            $table->integer('total_harga')->after('kuantiti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keranjang_obat', function (Blueprint $table) {
            //
        });
    }
};
