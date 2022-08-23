<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZutatenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zutaten', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('lagerbestand');
            $table->double('mindestbestand');
            $table->integer('lieferant')->nullable();
            $table->integer('einheit');
            $table->boolean('round')->nullable();
            $table->integer('lagerort')->nullable();
            $table->text('picture')->nullable();
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
        Schema::dropIfExists('zutaten');
    }
}
