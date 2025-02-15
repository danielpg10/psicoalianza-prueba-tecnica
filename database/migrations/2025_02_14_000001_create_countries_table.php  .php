<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    
        DB::table('countries')->insert([
            ['name' => 'Colombia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Argentina', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'México', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ecuador', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}