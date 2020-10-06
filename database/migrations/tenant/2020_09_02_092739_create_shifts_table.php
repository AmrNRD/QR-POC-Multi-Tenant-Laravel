<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {

			$table->id();
			$table->string('name');
            $table->enum('type',['fixed','flexible'])->default('flexible');
            $table->double('threshold')->nullable();
			$table->time('start_at')->nullable();
			$table->time('end_at')->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
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
        Schema::dropIfExists('shifts');
    }
}
