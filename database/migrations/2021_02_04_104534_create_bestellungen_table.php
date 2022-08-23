<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBestellungenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bestellungen', function (Blueprint $table) {
            $table->id();
            $table->integer('lieferant');
            $table->text('bestellnotiz')->nullable();
            $table->text('lagernotiz')->nullable();
            $table->text('endnotiz')->nullable();
            $table->integer('child_id')->nullable();
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
        Schema::dropIfExists('bestellungen');
    }
}
