<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chi_tiet_phan_quyens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_quyen');
            $table->unsignedBigInteger('id_chuc_nang');
            $table->boolean('xem')->default(0);
            $table->boolean('them')->default(0);
            $table->boolean('sua')->default(0);
            $table->boolean('xoa')->default(0);
            $table->timestamps();

            $table->foreign('id_quyen')->references('id')->on('quyens')->onDelete('cascade');
            $table->foreign('id_chuc_nang')->references('id')->on('chuc_nangs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_phan_quyens');
    }
};
