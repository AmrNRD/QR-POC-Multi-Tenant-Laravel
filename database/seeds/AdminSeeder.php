<?php

use App\Domain\Admin\Entities\Admin;
use App\Domain\Tenant\User\Entities\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        if(Schema::hasTable('users')){
            $admin = User::create([
                'name' => $faker->name,
                'email' => 'admin@joovlly.com',
                'email_verified_at' => now(),
                'mobile' => $faker->unique()->numberBetween(1, 1500),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);
            $admin->roles()->sync([1]);
        }else if(Schema::hasTable('admins')){
            $admin = Admin::create([
                'name' => $faker->name,
                'email' => 'admin@joovlly.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);
            $admin->roles()->sync([1]);
        }
    }

}
