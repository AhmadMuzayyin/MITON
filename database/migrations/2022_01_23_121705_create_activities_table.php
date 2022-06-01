<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pak_id');
            $table->foreignId('user_id');
            $table->foreignId('sumber_dana_id');
            $table->foreignId('pengadaan_id');
            $table->foreignId('pelaksanaan_id');
            $table->string('rek');
            $table->string('nama');
            $table->string('kegiatan');
            $table->string('dau')->nullable();
            $table->string('dak')->nullable();
            $table->string('dbhc')->nullable();
            $table->string('program');
            $table->string('keterangan');
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
        Schema::dropIfExists('activities');
    }
}
