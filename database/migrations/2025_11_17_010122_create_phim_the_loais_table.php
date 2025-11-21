<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('phim_the_loais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_phim');
            $table->unsignedBigInteger('id_the_loai');

            $table->foreign('id_phim')->references('id')->on('phims')->onDelete('cascade');
            $table->foreign('id_the_loai')->references('id')->on('the_loais')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phim_the_loais');
    }
};
