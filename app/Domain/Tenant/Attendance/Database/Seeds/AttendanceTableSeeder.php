<?php

namespace App\Domain\Tenant\Attendance\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Tenant\Attendance\Entities\Attendance;

class AttendanceTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(Attendance::class,1000)->create();
    }
}
