<?php

namespace App\Domain\Tenant\Employee\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Tenant\Employee\Entities\EmployeeDevices;

class EmployeeDevicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(EmployeeDevices::class,1000)->create();
    }
}
