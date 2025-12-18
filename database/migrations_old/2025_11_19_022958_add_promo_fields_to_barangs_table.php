<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->boolean('is_flash_sale')->default(false)->after('berlaku_sampai');
            $table->unsignedTinyInteger('diskon')->nullable()->after('is_flash_sale'); // persen diskon, ex: 30
            $table->integer('stok_flash_sale')->nullable()->after('diskon')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['is_flash_sale', 'diskon', 'stok_flash_sale']);
        });
    }
};
