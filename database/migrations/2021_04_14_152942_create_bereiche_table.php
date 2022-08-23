<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBereicheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bereiche', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });

        // insert empty value
        DB::table('bereiche')->insert([
            ['id' => 1, 'name' => 'Küche', 'created_at' => '2021-01-01 00:00:00', 'updated_at' => '2021-01-01 00:00:00'],
            ['id' => 2, 'name' => 'Bar', 'created_at' => '2021-01-01 00:00:00', 'updated_at' => '2021-01-01 00:00:00'],
            ['id' => 3, 'name' => 'Eis', 'created_at' => '2021-01-01 00:00:00', 'updated_at' => '2021-01-01 00:00:00'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bereiche');
    }
}
