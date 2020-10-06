<?php

namespace App\Domain\Tenant\Employee\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Tenant\Employee\Entities\Employee;

class EmployeeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(Employee::class,1000)->create();
    }
}
