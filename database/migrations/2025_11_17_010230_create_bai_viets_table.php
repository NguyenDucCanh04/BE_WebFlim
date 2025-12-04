<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bai_viets', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de');
            $table->text('noi_dung');
            $table->string('anh_dai_dien')->nullable();
            $table->timestamp('ngay_dang');
            $table->unsignedBigInteger('tac_gia'); // admin
            $table->integer('trang_thai')->default(1); // 1: active, 0: inactive    
            $table->timestamps();

            $table->foreign('tac_gia')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bai_viets');
    }
};
