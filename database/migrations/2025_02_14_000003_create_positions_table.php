<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_unique')->default(false);
            $table->timestamps();
        });
    
        DB::table('positions')->insert([
            ['name' => 'Presidente', 'is_unique' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Empleado', 'is_unique' => false, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jefe', 'is_unique' => false, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions');
    }
}
