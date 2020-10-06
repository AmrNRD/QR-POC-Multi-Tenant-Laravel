<?php

namespace App\Domain\Subscription\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Subscription\Entities\Plan;

class PlanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(Plan::class,1000)->create();
    }
}
