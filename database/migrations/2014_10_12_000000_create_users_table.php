<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('kode_SKPD')->uniqid();
            $table->string('nama_SKPD');
            $table->string('nama_operator');
            $table->string('no_hp');
            $table->string('no_kantor');
            $table->string('alamat_kantor');
            $table->string('username')->uniqid();
            $table->string('password');
            $table->string('nama_KPA');
            $table->string('foto')->nullable();
            $table->string('isAdmin');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
