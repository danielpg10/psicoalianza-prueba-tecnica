<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('country_id')
            ->constrained()
            ->onDelete('cascade'); 
            $table->timestamps();
        });

        if (DB::table('cities')->count() === 0) {
            $cities = [
                ['name' => 'Bogotá', 'country_id' => 1],
                ['name' => 'Medellín', 'country_id' => 1],
                ['name' => 'Cali', 'country_id' => 1],
                ['name' => 'Buenos Aires', 'country_id' => 2],
                ['name' => 'Córdoba', 'country_id' => 2],
                ['name' => 'Rosario', 'country_id' => 2],
                ['name' => 'Ciudad de México', 'country_id' => 3],
                ['name' => 'Guadalajara', 'country_id' => 3],
                ['name' => 'Monterrey', 'country_id' => 3],
                ['name' => 'Quito', 'country_id' => 4],
                ['name' => 'Guayaquil', 'country_id' => 4],
                ['name' => 'Cuenca', 'country_id' => 4]
            ];

            DB::table('cities')->insert($cities);
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
