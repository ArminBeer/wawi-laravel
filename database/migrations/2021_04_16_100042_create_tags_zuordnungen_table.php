<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsZuordnungenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_zuordnungen', function (Blueprint $table) {
            $table->id();
            $table->integer('tag');
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
        Schema::dropIfExists('tags_zuordnungen');
    }
}
