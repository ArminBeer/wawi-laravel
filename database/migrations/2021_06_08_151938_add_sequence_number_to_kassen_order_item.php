<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSequenceNumberToKassenOrderItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kassen_order_items', function (Blueprint $table) {
            $table->integer('sequenceNumber')->nullable()->after('kassen_order_id');
            $table->unique(['sequenceNumber', 'kassen_order_id'], 'unique_sequence_in_item');
        });

        $i = 0;
        $items = \App\Models\KassenOrderItem::all();
        foreach ($items as $item) {
            $item->sequenceNumber = $i;
            $item->save();
            $i++;
        }
        Schema::table('kassen_order_items', function (Blueprint $table) {
            $table->integer('sequenceNumber')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kassen_order_items', function (Blueprint $table) {
            $table->dropUnique('unique_sequence_in_item');
            $table->dropColumn('sequenceNumber');
        });
    }
}
