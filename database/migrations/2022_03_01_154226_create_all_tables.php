<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf')->unique();
            $table->integer('cidade');
            $table->integer('estado');

        });


        //  Schema::create('tb_cidades', function (Blueprint $table) {
        //      $table->id();
        //      $table->integer('estado');
        //      $table->string('uf');
        //      $table->string('nome');
        //  });
        //
        //  Schema::create('tb_estados', function (Blueprint $table) {
        //      $table->id();
        //      $table->string('uf');
        //      $table->string('nome');
        //  });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_pessoas');

        // Schema::dropIfExists('tb_cidades');
        // Schema::dropIfExists('tb_estados');
    }
};
