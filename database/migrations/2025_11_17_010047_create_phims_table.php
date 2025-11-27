<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('phims', function (Blueprint $table) {
            $table->id();
            $table->string('ten_phim');
            $table->text('mo_ta');
            $table->string('dao_dien');
            $table->text('dien_vien');
            $table->integer('thoi_luong');
            $table->integer('nam_san_xuat');
            $table->string('quoc_gia');
            $table->string('trailer_url')->nullable();
            $table->string('movie_url')->nullable();
            $table->string('poster_url')->nullable();
            $table->timestamp('ngay_tao')->useCurrent();
            $table->timestamp('ngay_khoi_chieu')->nullable();
            $table->tinyInteger('trang_thai')->default(1);
            $table->tinyInteger('trang_thai_chieu')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phims');
    }
};
