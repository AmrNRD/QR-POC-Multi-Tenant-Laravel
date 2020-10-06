<?php

namespace App\Domain\Subscription\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Subscription\Entities\Subscription;

class SubscriptionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(Subscription::class,1000)->create();
    }
}
