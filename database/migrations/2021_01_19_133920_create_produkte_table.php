<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produkte', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->integer('type')->nullable();
            $table->integer('zubereitung')->nullable();
            $table->integer('zutat')->nullable();
            $table->double('ertrag');
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
        Schema::dropIfExists('produkte');
    }
}
