<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZutatenZuRezepteProdukteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zutaten_zu_rezepte_produkte', function (Blueprint $table) {
            $table->id();
            $table->integer('zutat');
            $table->integer('verknuepfung_id');
            $table->string('verknuepfung_type');
            $table->double('menge')->nullable();
            $table->string('einheit')->nullable();
            $table->double('verlust')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zutaten_zu_rezepte_produkte');
    }
}
