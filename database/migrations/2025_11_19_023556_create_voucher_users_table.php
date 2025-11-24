<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voucher_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voucher_id');
            $table->unsignedBigInteger('pelanggan_id')->nullable(); // bisa null untuk guest (opsional)
            $table->string('kode')->nullable();
            $table->timestamp('claimed_at')->nullable();
            $table->timestamps();

            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
            $table->foreign('pelanggan_id')->references('pelanggan_id')->on('pelanggans')->onDelete('cascade');
            $table->unique(['voucher_id', 'pelanggan_id'], 'voucher_user_unique'); // prevent double claim
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voucher_users');
    }
};
