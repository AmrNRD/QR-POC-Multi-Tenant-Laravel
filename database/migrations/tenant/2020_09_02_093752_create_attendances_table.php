<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {

			$table->id();
			$table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->unsignedBigInteger('employee_shift_id');
            $table->foreign('employee_shift_id')->references('id')->on('employee_shifts')->onDelete('cascade');
            $table->date('date');
            $table->time('check_in');
            $table->time('check_out')->nullable();
            $table->time('shift_start');
            $table->time('shift_end');
            $table->enum('status',['not_accepted','checked_in','missed_check_in','missed_check_in_but_checked_out','checked_out','work_hours_not_completed'])->default('checked_in');
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
        Schema::dropIfExists('attendances');
    }
}
