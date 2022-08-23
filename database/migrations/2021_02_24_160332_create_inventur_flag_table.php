<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInventurFlagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventur_flag', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->integer('user')->nullable();
            $table->timestamps();
        });

        // insert empty value
        DB::table('inventur_flag')->insert([
            ['id' => 1, 'active' => '0', 'created_at' => '2021-01-01 00:00:00', 'updated_at' => '2021-01-01 00:00:00'],
            ['id' => 2, 'active' => '0', 'created_at' => '2021-01-01 00:00:00', 'updated_at' => '2021-01-01 00:00:00'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventur_flag');
    }
}
