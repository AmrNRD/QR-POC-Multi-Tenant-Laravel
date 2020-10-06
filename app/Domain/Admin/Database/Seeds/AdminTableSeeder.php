<?php

namespace App\Domain\Admin\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Admin\Entities\Admin;

class AdminTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(Admin::class,1000)->create();
    }
}
