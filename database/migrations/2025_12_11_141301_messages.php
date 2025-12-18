<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sender_id');
            $table->string('sender_type'); // admin / pelanggan

            $table->unsignedBigInteger('receiver_id');
            $table->string('receiver_type'); // admin / pelanggan

            $table->text('message');
            $table->timestamps();
        });
    }

};
