<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLagerorteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lagerorte', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('picture')->nullable();
            $table->timestamps();
        });

        // insert empty value
        DB::table('lagerorte')->insert([
            ['id' => 1, 'name' => 'Inventar', 'picture' => null, 'created_at' => '2021-01-01 00:00:00', 'updated_at' => '2021-01-01 00:00:00'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lagerorte');
    }
}
