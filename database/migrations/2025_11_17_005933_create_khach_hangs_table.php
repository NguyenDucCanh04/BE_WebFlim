<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('khach_hangs', function (Blueprint $table) {
            $table->id();
            $table->string('ho_ten');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('so_dien_thoai');
            $table->tinyInteger('gioi_tinh')->default(1)->comment('1 = Nam, 0 = Nữ');
            $table->date('ngay_sinh');
            $table->string('anh_dai_dien')->nullable();
            $table->boolean('trang_thai')->default(1);
            $table->timestamps();
            $table->string('hash_reset')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('khach_hangs');
    }
};
