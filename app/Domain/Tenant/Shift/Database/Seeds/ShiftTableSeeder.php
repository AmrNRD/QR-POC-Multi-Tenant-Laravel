<?php

namespace App\Domain\Tenant\Shift\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Tenant\Shift\Entities\Shift;

class ShiftTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(Shift::class,1000)->create();
    }
}
