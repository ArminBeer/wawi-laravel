<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZutatenFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zutaten', function (Blueprint $table) {
            $table->integer('conversion_einheit')->after('einheit')->nullable();
            $table->double('faktor')->after('conversion_einheit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zutaten', function (Blueprint $table) {
            $table->dropColumn('conversion_einheit');
            $table->dropColumn('faktor');
        });
    }
}
