
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLichChieusTable extends Migration
{
    public function up(): void
    {
        Schema::create('lich_chieus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_phim')->nullable();
            $table->unsignedBigInteger('id_phong')->nullable();
            $table->dateTime('ngay_gio_bat_dau')->nullable();
            $table->integer('gia')->default(0);
            $table->timestamps();

            // optional: add indexes / foreign keys if your other tables exist
            // $table->foreign('id_phim')->references('id')->on('phims')->onDelete('cascade');
            // $table->foreign('id_phong')->references('id')->on('phongs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lich_chieus');
    }
}
