<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftdeleteToAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('allergene', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('zutaten', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('rezepte', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('umrechnungen', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('produkte', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('zubereitungen', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('lieferanten', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('bons', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('zutaten_zu_allergene', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('zutaten_zu_rezepte_produkte', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('naehrwerte', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('rezepte_zu_naehrwerte', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('bestellungen', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('bestellungen_zu_zutaten', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('bestellung_activities', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('einheiten', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('lagerorte', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('inventuren', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('inventur_activities', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
        Schema::table('logs', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('allergene', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('zutaten', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('rezepte', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('umrechnungen', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('produkte', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('zubereitungen', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('lieferanten', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('bons', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('zutaten_zu_allergene', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('zutaten_zu_rezepte_produkte', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('naehrwerte', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('rezepte_zu_naehrwerte', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('bestellungen', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('bestellungen_zu_zutaten', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('bestellung_activities', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('einheiten', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('lagerorte', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('inventuren', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('inventur_activities', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
        Schema::table('logs', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('deleted_by');
        });
    }
}
