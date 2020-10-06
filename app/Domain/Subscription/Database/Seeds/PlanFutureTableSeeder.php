<?php

namespace App\Domain\Subscription\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Subscription\Entities\PlanFuture;

class PlanFutureTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(PlanFuture::class,1000)->create();
    }
}
