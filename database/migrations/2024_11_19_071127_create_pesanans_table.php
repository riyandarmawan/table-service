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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->string('id_pesanan')->primary();
            $table->integer('id_menu');
            $table->integer('id_meja');
            $table->integer('id_pelanggan');
            $table->integer('jumlah');
            $table->integer('id_user');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign(columns: 'id_menu')->references('id_menu')->on('menus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(columns: 'id_meja')->references('id_meja')->on('mejas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
