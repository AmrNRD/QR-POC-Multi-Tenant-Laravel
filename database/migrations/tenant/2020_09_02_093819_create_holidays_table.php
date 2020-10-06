<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {

			$table->id();
			$table->string('name');
			$table->integer('day')->nullable();
            $table->integer('month')->nullable();
            $table->integer('quarter')->nullable();
            $table->integer('day_of_week')->nullable();
            $table->integer('year')->nullable();
            $table->date('date')->nullable();
            $table->enum('type',['hijri','gregorian'])->default('gregorian');
            $table->enum('active', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holidays');
    }
}
