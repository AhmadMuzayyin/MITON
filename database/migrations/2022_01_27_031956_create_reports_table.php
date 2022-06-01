<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id');
            $table->foreignId('user_id');
            $table->foreignId('pak_id');
            $table->foreignId('month_id');
            $table->foreignId('sumber_dana_id');
            $table->foreignId('t_keuangan_id');
            $table->foreignId('target_id');
            $table->integer('kegiatan_lalu')->nullable();
            $table->integer('kegiatan_sekarang')->nullable();
            $table->integer('keuangan_lalu')->nullable();
            $table->integer('keuangan_sekarang')->nullable();
            $table->string('kendala')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
