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
        Schema::table('persediaan', function (Blueprint $table) {
            $table->unsignedBigInteger('pembelian_id')->after('obat_id');

            $table->foreign("pembelian_id")->references("id")->on("pembelian");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persediaan', function (Blueprint $table) {
            $table->dropForeign(['pembelian_id']);
            $table->removeColumn('pembelian_id');
        });
    }
};
