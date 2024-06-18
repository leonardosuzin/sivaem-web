<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVagasTable extends Migration
{
    public function up()
    {
        Schema::create('vagas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('descricao', 255);
            $table->string('cargo', 20);
            $table->decimal('salario', 10, 2);
            $table->integer('id_user');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vagas');
    }
}
