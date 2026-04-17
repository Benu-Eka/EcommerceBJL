<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates all missing tables required by the application models.
     */
    public function up(): void
    {
        // 1. users table (needed by User model and admin auth)
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('user_id')->nullable()->index();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // 2. suppliers table (referenced by Barang model: belongsTo Supplier)
        if (!Schema::hasTable('suppliers')) {
            Schema::create('suppliers', function (Blueprint $table) {
                $table->bigIncrements('id_supplier');
                $table->string('nama_supplier');
                $table->string('alamat')->nullable();
                $table->string('telepon', 20)->nullable();
                $table->string('email')->nullable();
                $table->timestamps();
            });
        }

        // 3. stok_barangs table (referenced by StokBarang model)
        if (!Schema::hasTable('stok_barangs')) {
            Schema::create('stok_barangs', function (Blueprint $table) {
                $table->bigIncrements('id_stok');
                $table->string('kode_barang', 50)->index();
                $table->decimal('jumlah', 15, 2)->default(0);
                $table->string('lokasi')->nullable();
                $table->datetime('tanggal_masuk')->nullable();
                $table->datetime('tanggal_keluar')->nullable();
            });
        }

        // 4. surat_jalans table (referenced by SuratJalan model)
        if (!Schema::hasTable('surat_jalans')) {
            Schema::create('surat_jalans', function (Blueprint $table) {
                $table->string('sj_id', 25)->primary();
                $table->string('user_id')->nullable();
                $table->unsignedBigInteger('pelanggan_id')->index();
                $table->string('nama_penerima')->nullable();
                $table->datetime('tanggal_surat');
                $table->string('status')->default('Disetujui');
                $table->decimal('biaya_pengiriman', 15, 2)->default(0);
                $table->decimal('diskon_pelanggan', 15, 2)->default(0);
                $table->decimal('subtotal', 15, 2)->default(0);
                $table->timestamps();
            });
        }

        // 5. surat_jalan_details table (referenced by SuratJalanDetail model)
        if (!Schema::hasTable('surat_jalan_details')) {
            Schema::create('surat_jalan_details', function (Blueprint $table) {
                $table->string('detail_sj_id', 50)->primary();
                $table->string('sj_id', 25)->index();
                $table->string('kode_barang', 50);
                $table->unsignedBigInteger('harga_barang_id')->nullable();
                $table->integer('quantity')->default(0);
                $table->decimal('harga_satuan', 15, 2)->default(0);
                $table->string('satuan')->default('pcs');
                $table->timestamps();
            });
        }

        // 6. Add remember_token to pelanggans if missing (needed for Auth)
        if (Schema::hasTable('pelanggans') && !Schema::hasColumn('pelanggans', 'remember_token')) {
            Schema::table('pelanggans', function (Blueprint $table) {
                $table->rememberToken()->after('saldo');
            });
        }

        // 7. Fix order_items: add primary key if missing
        // Model expects 'order_item_id' but DB has 'id' — handled by keeping 'id'
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_jalan_details');
        Schema::dropIfExists('surat_jalans');
        Schema::dropIfExists('stok_barangs');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('users');

        if (Schema::hasColumn('pelanggans', 'remember_token')) {
            Schema::table('pelanggans', function (Blueprint $table) {
                $table->dropColumn('remember_token');
            });
        }
    }
};
