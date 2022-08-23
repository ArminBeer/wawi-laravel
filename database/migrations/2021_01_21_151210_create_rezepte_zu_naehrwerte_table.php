<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRezepteZuNaehrwerteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rezepte_zu_naehrwerte', function (Blueprint $table) {
            $table->id();
            $table->integer('rezept');
            $table->integer('naehrwert');
            $table->double('menge');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rezepte_zu_naehrwerte');
    }
}
