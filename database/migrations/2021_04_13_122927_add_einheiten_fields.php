<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEinheitenFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('einheiten', function (Blueprint $table) {
            $table->boolean('grundeinheit')->default(0)->after('kuerzel');
            $table->boolean('conversion_needed')->default(0)->after('grundeinheit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('einheiten', function (Blueprint $table) {
            $table->dropColumn('grundeinheit');;
            $table->dropColumn('conversion_needed');
        });
    }
}
