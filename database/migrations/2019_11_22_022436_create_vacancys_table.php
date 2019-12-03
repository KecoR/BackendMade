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
            $table->string('judul')->nullable();
            $table->longText('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->string('gaji')->nullable();
            $table->string('tipe_gaji')->nullable();
            $table->string('slot')->nullable();
            $table->string('buruh')->default('0');
            $table->string('luas_lahan')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
