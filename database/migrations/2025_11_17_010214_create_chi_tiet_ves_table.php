<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chi_tiet_ves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dat_ve');
            $table->unsignedBigInteger('id_ghe');
            $table->decimal('gia_ve', 10, 2);
            $table->timestamps();

            $table->foreign('id_dat_ve')->references('id')->on('dat_ves')->onDelete('cascade');
            $table->foreign('id_ghe')->references('id')->on('ghe_ngois')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_ves');
    }
};
