<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rezept')->constrained('rezepte')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('sku');
            $table->integer('business_id');
            $table->timestamps();
            $table->unique(['rezept', 'sku', 'business_id']);
        });

        Schema::table('rezepte', function (Blueprint $table) {
            $table->dropColumn('sku');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');

        Schema::table('rezepte', function (Blueprint $table) {
            $table->integer('sku')->after('name')->nullable();
        });
    }
}
