<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('identification')->unique();
            $table->string('address');
            $table->string('phone', 20);
            $table->boolean('is_president')->default(false);
            $table->foreignId('city_id')->constrained();
            $table->foreignId('boss_id')->nullable()->constrained('employees');
            $table->timestamps();
        });


        $presidente = DB::table('employees')->insert([
            'name' => 'Marlon Daniel',
            'surname' => 'Portuguez Gomez',
            'identification' => '1234567890',
            'address' => 'Cll45G#94-50',
            'phone' => '3226548790',
            'city_id' => DB::table('cities')->where('name', 'Bogotá')->first()->id,
            'is_president' => true,
            'boss_id' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }


    public function down()
    {
        Schema::dropIfExists('employees');
    }
}