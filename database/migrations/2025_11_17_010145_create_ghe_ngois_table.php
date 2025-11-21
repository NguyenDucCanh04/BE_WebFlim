<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ghe_ngois', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_phong');
            $table->string('so_ghe');
            $table->string('loai_ghe');
            $table->timestamps();

            $table->foreign('id_phong')->references('id')->on('phong_chieus')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ghe_ngois');
    }
};
