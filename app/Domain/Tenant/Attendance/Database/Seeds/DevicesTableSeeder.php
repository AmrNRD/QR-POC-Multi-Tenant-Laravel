<?php

namespace App\Domain\Tenant\Attendance\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Tenant\Attendance\Entities\Device;

class DevicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(Device::class,1000)->create();
    }
}
