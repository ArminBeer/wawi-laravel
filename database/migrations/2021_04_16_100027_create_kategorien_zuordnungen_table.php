<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategorienZuordnungenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategorien_zuordnungen', function (Blueprint $table) {
            $table->id();
            $table->integer('kategorie');
            $table->integer('verknuepfung_id');
            $table->string('verknuepfung_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kategorien_zuordnungen');
    }
}
