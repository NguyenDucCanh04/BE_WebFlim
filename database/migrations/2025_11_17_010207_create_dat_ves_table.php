<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dat_ves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_khach_hang');
            $table->unsignedBigInteger('id_suat_chieu');
            $table->decimal('tong_tien', 10, 2);
            $table->string('trang_thai');
            $table->timestamp('ngay_dat');
            $table->timestamps();

            $table->foreign('id_khach_hang')->references('id')->on('khach_hangs');
            $table->foreign('id_suat_chieu')->references('id')->on('suat_chieus');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dat_ves');
    }
};
