<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('suat_chieus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_phim');
            $table->unsignedBigInteger('id_phong');
            $table->dateTime('thoi_gian_bat_dau');
            $table->dateTime('thoi_gian_ket_thuc');

            $table->timestamps();

            $table->foreign('id_phim')->references('id')->on('phims');
            $table->foreign('id_phong')->references('id')->on('phong_chieus');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suat_chieus');
    }
};
