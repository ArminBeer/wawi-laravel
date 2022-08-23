<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKassenOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_periods', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id');
            $table->timestamp('businessDay')->nullable();
            $table->timestamp('startPeriodTimestamp')->nullable();
            $table->timestamp('finishPeriodTimestamp')->nullable();
            $table->integer('business_id');
            $table->timestamps();
        });
        Schema::create('kassen_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('business_period_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::create('kassen_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('kassen_order_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('itemSku');
            $table->float('quantity');
            $table->float('units');
            $table->timestamp('recordedTimestamp');
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
        Schema::dropIfExists('kassen_order_items');
        Schema::dropIfExists('kassen_orders');
        Schema::dropIfExists('business_periods');
    }
}
