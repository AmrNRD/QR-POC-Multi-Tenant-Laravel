<?php

namespace App\Domain\Company\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Company\Entities\Company;

class CompanyTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(Company::class,1000)->create();
    }
}
