<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('the_loais', function (Blueprint $table) {
            $table->id();
            $table->string('ten_the_loai');
            $table->string('mo_ta')->nullable();
            $table->integer('trang_thai')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('the_loais');
    }
};
