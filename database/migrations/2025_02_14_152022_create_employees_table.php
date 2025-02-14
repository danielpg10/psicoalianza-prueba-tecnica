<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->foreignId('city_id')->constrained()->nullOnDelete()->index();
            $table->foreignId('boss_id')->nullable()->constrained('employees')->nullOnDelete()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}