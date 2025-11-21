<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('danh_gia_phims', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_phim');
            $table->unsignedBigInteger('id_khach_hang');
            $table->integer('so_sao');
            $table->text('binh_luan')->nullable();
            $table->timestamp('ngay_danh_gia');
            $table->timestamps();

            $table->foreign('id_phim')->references('id')->on('phims')->onDelete('cascade');
            $table->foreign('id_khach_hang')->references('id')->on('khach_hangs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('danh_gia_phims');
    }
};
