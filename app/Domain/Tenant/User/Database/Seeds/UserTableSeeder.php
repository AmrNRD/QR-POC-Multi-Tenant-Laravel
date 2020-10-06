<?php

namespace App\Domain\Tenant\User\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Tenant\User\Entities\User;

class UserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(User::class,1000)->create();
    }
}
