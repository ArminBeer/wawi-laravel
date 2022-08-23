<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBestellungActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bestellung_activities', function (Blueprint $table) {
            $table->id();
            $table->integer('bestellung')->nullable();
            $table->string('status')->nullable();
            $table->integer('user')->nullable();
            $table->text('changes')->nullable();
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
        Schema::dropIfExists('bestellung_activities');
    }
}
