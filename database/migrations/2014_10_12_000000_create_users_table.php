<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->text('picture')->nullable();
            $table->boolean('staff_right')->default(0);
            $table->boolean('kitchen_watch_right')->default(0);
            $table->boolean('kitchen_edit_right')->default(0);
            $table->boolean('warehouse_right')->default(0);
            $table->boolean('stocktaking_right')->default(0);
            $table->boolean('order_right')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Insert API User
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'API Kassensystem', 'email' => 'info@strizzi.de',
            'staff_right' => '1',
            'kitchen_watch_right' => '1',
            'kitchen_edit_right' => '1',
            'warehouse_right' => '1',
            'stocktaking_right' => '1',
            'order_right' => '1',
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
        Schema::dropIfExists('users');
    }
}
