<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama')->nullable();
            $table->text('keterangan')->nullable();
            $table->decimal('nilai_diskon', 15, 2)->nullable(); // bisa berupa nominal
            $table->unsignedTinyInteger('persen_diskon')->nullable(); // atau persen
            $table->decimal('min_order', 15, 2)->default(0); // minimal order
            $table->integer('kuota')->nullable(); // total klaim limit (nullable = unlimited)
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
