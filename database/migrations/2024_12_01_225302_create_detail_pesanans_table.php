<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('id_pesanan');
            $table->string('id_menu');
            $table->integer('jumlah');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign(columns: 'id_pesanan')->references('id_pesanan')->on('pesanans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(columns: 'id_menu')->references('id_menu')->on('menus')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};
