<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('thanh_toans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dat_ve');
            $table->string('phuong_thuc');
            $table->decimal('so_tien', 10, 2);
            $table->timestamp('thoi_gian');
            $table->string('trang_thai');
            $table->timestamps();

            $table->foreign('id_dat_ve')->references('id')->on('dat_ves')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thanh_toans');
    }
};
