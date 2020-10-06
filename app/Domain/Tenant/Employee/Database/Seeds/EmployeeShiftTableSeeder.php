<?php

namespace App\Domain\Tenant\Employee\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Tenant\Employee\Entities\EmployeeShift;

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
