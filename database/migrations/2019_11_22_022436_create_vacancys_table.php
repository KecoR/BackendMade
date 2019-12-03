<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul');
            $table->longText('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->string('gaji');
            $table->string('tipe_gaji');
            $table->string('slot');
            $table->string('buruh')->default('0');
            $table->string('luas_lahan');
            $table->string('latitude');
            $table->string('longitude');
            $table->char('status', 2)->default('0');
            $table->bigInteger('pemilik_id');
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
        Schema::dropIfExists('vacancies');
    }
}
