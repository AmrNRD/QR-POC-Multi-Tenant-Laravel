<?php

namespace App\Domain\Tenant\Shift\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Tenant\Shift\Entities\EmployeeShift;

class EmployeeShiftTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(EmployeeShift::class,1000)->create();
    }
}
