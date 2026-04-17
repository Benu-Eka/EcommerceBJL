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
        Schema::create('saldo_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelanggan_id')->index();
            $table->string('order_id')->nullable()->index();
            $table->string('tipe'); // e.g. refund, payment, topup
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->decimal('saldo_sebelum', 15, 2)->default(0);
            $table->decimal('saldo_sesudah', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldo_transactions');
    }
};
