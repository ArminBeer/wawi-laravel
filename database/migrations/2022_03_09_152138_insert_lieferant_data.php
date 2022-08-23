<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertLieferantData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('lieferanten')->insert([
            ['id' => 1,
            'name' => 'Mise en Place',
            'email' => 'info@strizzi.de',
            'ansprechpartner' => '',
            'telefon' => '',
            'plz' => '',
            'strasse' => '',
            'ort' => '',
            'land' => '',
            'created_at' => '2021-01-01 00:00:00', 'updated_at' => '2021-01-01 00:00:00'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('lieferanten')->where("id", 1)->delete();
    }
}
