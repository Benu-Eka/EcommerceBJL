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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'telepon')) {
                $table->string('telepon')->nullable();
            }
            if (!Schema::hasColumn('orders', 'pelanggan_id')) {
                $table->unsignedBigInteger('pelanggan_id')->nullable();
            }
            if (!Schema::hasColumn('orders', 'midtrans_order_id')) {
                $table->string('midtrans_order_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'telepon')) {
                $table->dropColumn('telepon');
            }
            if (Schema::hasColumn('orders', 'pelanggan_id')) {
                $table->dropColumn('pelanggan_id');
            }
            if (Schema::hasColumn('orders', 'midtrans_order_id')) {
                $table->dropColumn('midtrans_order_id');
            }
        });
    }
};
