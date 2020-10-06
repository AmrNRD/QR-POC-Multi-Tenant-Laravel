<?php

namespace App\Domain\Tenant\Attendance\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Tenant\Attendance\Entities\Holidays;

class HolidaysTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(Holidays::class,1000)->create();
    }
}
