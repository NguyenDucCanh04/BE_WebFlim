<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('phong_chieus', function (Blueprint $table) {
            $table->id();
            $table->string('ten_phong');
            $table->integer('so_ghe');
            $table->string('mo_ta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phong_chieus');
    }
};
