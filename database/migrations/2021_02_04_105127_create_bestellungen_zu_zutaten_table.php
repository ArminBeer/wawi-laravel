<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBestellungenZuZutatenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bestellungen_zu_zutaten', function (Blueprint $table) {
            $table->id();
            $table->integer('bestellung');
            $table->integer('zutat');
            $table->double('bestellmenge');
            $table->double('liefermenge')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bestellungen_zu_zutaten');
    }
}
