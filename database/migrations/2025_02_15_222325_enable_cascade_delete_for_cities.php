<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class EnableCascadeDeleteForCities extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            Schema::rename('cities', 'old_cities');
            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('country_id')
                      ->constrained()
                      ->onDelete('cascade');
                $table->timestamps();
            });
            DB::table('cities')->insertUsing(
                ['id', 'name', 'country_id', 'created_at', 'updated_at'],
                DB::table('old_cities')->select('*')
            );
            Schema::drop('old_cities');
        } else {
            Schema::table('cities', function (Blueprint $table) {
                $table->dropForeign(['country_id']);
                $table->foreign('country_id')
                      ->references('id')
                      ->on('countries')
                      ->onDelete('cascade');
            });
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();

        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            Schema::rename('cities', 'old_cities');
            
            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('country_id')->constrained();
                $table->timestamps();
            });

            DB::table('cities')->insertUsing(
                ['id', 'name', 'country_id', 'created_at', 'updated_at'],
                DB::table('old_cities')->select('*')
            );

            Schema::drop('old_cities');
        } else {
            Schema::table('cities', function (Blueprint $table) {
                $table->dropForeign(['country_id']);
                $table->foreign('country_id')
                      ->references('id')
                      ->on('countries');
            });
        }

        Schema::enableForeignKeyConstraints();
    }
}