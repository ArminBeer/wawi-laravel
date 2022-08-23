<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLieferantenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lieferanten', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('ansprechpartner')->nullable();
            $table->string('telefon')->nullable();
            $table->integer('plz')->nullable();
            $table->string('strasse')->nullable();
            $table->string('ort')->nullable();
            $table->string('land')->nullable();
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
        Schema::dropIfExists('lieferanten');
    }
}
