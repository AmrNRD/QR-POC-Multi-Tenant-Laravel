<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'slug' => 'super_admin',
            'name' => 'Super Admin',
            'permissions' =>json_encode ( [
                // plan
                'create-plans' => true,
                'view-plan' => true,
                'view-plans' => true,
                'update-plans' => true,
                'activate-plans' => true,
                'deactivate-plans' => true,
                // end plan
                // plan_subscription
                'create-plan_subscriptions' => true,
                'view-plan_subscription' => true,
                'view-plan_subscriptions' => true,
                'update-plan_subscriptions' => true,
                'delete-plan_subscriptions' => true,
                // end plan_subscription
                // mark_payment_paid
                'create-mark_payments_paid' => true,
                'view-mark_payment_paid' => true,
                'view-mark_payments_paid' => true,
                'update-mark_payments_paid' => true,
                'delete-mark_payments_paid' => true,
                // end mark_payment_paid
                // company
                'create-companies' => true,
                'view-company' => true,
                'view-companies' => true,
                'update-companies' => true,
                'activate-companies' => true,
                'deactivate-companies' => true,
                //end company
                // company plan
                'create-company_plans' => true,
                'view-company_plan' => true,
                'view-company_plans' => true,
                'update-company_plans' => true,
                'activate-company_plans' => true,
                'deactivate-company_plans' => true,
                //end company plan
                // ----role
                'create-roles' => true,
                'view-role' => true,
                'view-roles' => true,
                'update-roles' => true,
                'activate-roles' => true,
                'deactivate-roles' => true,
                // ----end role
                // admin
                'create-admin' => true,
                'view-admin' => true,
                'view-admins' => true,
                'update-admins' => true,
                'activate-admins' => true,
                'deactivate-admins' => true,
                // end admin
                // user
                'create-users' => true,
                'view-user' => true,
                'view-users' => true,
                'update-users' => true,
                'activate-users' => true,
                'deactivate-users' => true,
                // end user
                // employee
                'create-employees' => true,
                'view-employee' => true,
                'view-employees' => true,
                'update-employees' => true,
                'activate-employees' => true,
                'deactivate-employees' => true,
                // end employee

                // shift
                'create-shifts' => true,
                'view-shift' => true,
                'view-shifts' => true,
                'update-shifts' => true,
                'activate-shifts' => true,
                'deactivate-shifts' => true,
                // end shift

                // employee-shifts
                'create-employee-shifts' => true,
                'view-employee-shift' => true,
                'view-employee-shifts' => true,
                'update-employee-shifts' => true,
                'activate-employee-shifts' => true,
                'deactivate-employee-shifts' => true,
                // end employee-shifts

                // attendance
                'create-attendances' => true,
                'register-attendance-qr'=>true,
                'view-attendance' => true,
                'view-attendances' => true,
                'update-attendances' => true,
                'activate-attendances' => true,
                'deactivate-attendances' => true,
                // end attendance

                // devices
                'view-devices' => true,
                'activate-device' => true,
                //end devices

                // holidays
                'create-holidays' => true,
                'view-holiday' => true,
                'view-holidays' => true,
                'update-holidays' => true,
                'activate-holidays' => true,
                'deactivate-holidays' => true,
                // end holidays
            ]),
        ]);
        DB::table('roles')->insert([
            'slug' => 'CompanyAdmin',
            'name' => 'CompanyAdmin',
            'permissions' => json_encode ([
                // plan
                'create-plans' => false,
                'view-plan' => false,
                'view-plans' => false,
                'update-plans' => false,
                'activate-plans' => false,
                'deactivate-plans' => false,
                // end plan

                // plan_subscription
                'create-plan_subscriptions' => false,
                'view-plan_subscription' => false,
                'view-plan_subscriptions' => false,
                'update-plan_subscriptions' => false,
                'delete-plan_subscriptions' => false,
                // end plan_subscription

                // mark_payment_paid
                'create-mark_payments_paid' => false,
                'view-mark_payment_paid' => false,
                'view-mark_payments_paid' => false,
                'update-mark_payments_paid' => false,
                'delete-mark_payments_paid' => false,
                // end mark_payment_paid

                // company
                'create-companies' => false,
                'view-company' => false,
                'view-companies' => false,
                'update-companies' => false,
                'activate-companies' => false,
                'deactivate-companies' => false,
                //end company

                // company plan
                'create-company_plans' => false,
                'view-company_plan' => false,
                'view-company_plans' => false,
                'update-company_plans' => false,
                'activate-company_plans' => false,
                'deactivate-company_plans' => false,
                //end company plan

                // ----role
                'create-roles' => false,
                'view-role' => false,
                'view-roles' => false,
                'update-roles' => false,
                'activate-roles' => false,
                'deactivate-roles' => false,
                // ----end role

                // admin
                'create-admin' => false,
                'view-admin' => false,
                'view-admins' => false,
                'update-admins' => false,
                'activate-admins' => false,
                'deactivate-admins' => false,
                // end admin

                // user
                'create-users' => true,
                'view-user' => true,
                'view-users' => true,
                'update-users' => true,
                'activate-users' => true,
                'deactivate-users' => true,
                // end user

                // employee
                'create-employees' => true,
                'view-employee' => true,
                'view-employees' => true,
                'update-employees' => true,
                'activate-employees' => true,
                'deactivate-employees' => true,
                // end employee

                // shift
                'create-shifts' => true,
                'view-shift' => true,
                'view-shifts' => true,
                'update-shifts' => true,
                'activate-shifts' => true,
                'deactivate-shifts' => true,
                // end shift

                // employee-shifts
                'create-employee-shifts' => true,
                'view-employee-shift' => true,
                'view-employee-shifts' => true,
                'update-employee-shifts' => true,
                'activate-employee-shifts' => true,
                'deactivate-employee-shifts' => true,
                // end employee-shifts

                // devices
                'view-devices' => true,
                'activate-device' => true,
                //end devices

                // attendance
                'create-attendances' => true,
                'register-attendance-qr'=>true,
                'view-attendance' => true,
                'view-attendances' => true,
                'update-attendances' => true,
                'activate-attendances' => true,
                'deactivate-attendances' => true,
                // end attendance
            ]),
        ]);
        DB::table('roles')->insert([
            'slug' => 'user',
            'name' => 'User',
            'permissions' => json_encode([
                // plan
                'create-plans' => false,
                'view-plan' => false,
                'view-plans' => false,
                'update-plans' => false,
                'activate-plans' => false,
                'deactivate-plans' => false,
                // end plan

                // plan_subscription
                'create-plan_subscriptions' => false,
                'view-plan_subscription' => false,
                'view-plan_subscriptions' => false,
                'update-plan_subscriptions' => false,
                'delete-plan_subscriptions' => false,
                // end plan_subscription

                // mark_payment_paid
                'create-mark_payments_paid' => false,
                'view-mark_payment_paid' => false,
                'view-mark_payments_paid' => false,
                'update-mark_payments_paid' => false,
                'delete-mark_payments_paid' => false,
                // end mark_payment_paid

                // company
                'create-companies' => false,
                'view-company' => false,
                'view-companies' => false,
                'update-companies' => false,
                'activate-companies' => false,
                'deactivate-companies' => false,
                //end company

                // company plan
                'create-company_plans' => false,
                'view-company_plan' => false,
                'view-company_plans' => false,
                'update-company_plans' => false,
                'activate-company_plans' => false,
                'deactivate-company_plans' => false,
                //end company plan

                // ----role
                'create-roles' => false,
                'view-role' => false,
                'view-roles' => false,
                'update-roles' => false,
                'activate-roles' => false,
                'deactivate-roles' => false,
                // ----end role

                // admin
                'create-admin' => false,
                'view-admin' => false,
                'view-admins' => false,
                'update-admins' => false,
                'activate-admins' => false,
                'deactivate-admins' => false,
                // end admin

                // user
                'create-users' => false,
                'view-user' => true,
                'view-users' => false,
                'update-users' => false,
                'activate-users' => false,
                'deactivate-users' => false,
                // end user

                // employee
                'create-employees' => false,
                'view-employee' => false,
                'view-employees' => false,
                'update-employees' => false,
                'activate-employees' => false,
                'deactivate-employees' => false,
                // end employee

                // shift
                'create-shifts' => false,
                'view-shift' => false,
                'view-shifts' => false,
                'update-shifts' => false,
                'activate-shifts' => false,
                'deactivate-shifts' => false,
                // end shift

                // employee-shifts
                'create-employee-shifts' => false,
                'view-employee-shift' => false,
                'view-employee-shifts' => false,
                'update-employee-shifts' => false,
                'activate-employee-shifts' => false,
                'deactivate-employee-shifts' => false,
                // end employee-shifts

                // devices
                'view-devices' => false,
                'activate-device' => false,
                //end devices

                // attendance
                'create-attendances' => true,
                'register-attendance-qr'=>false,
                'view-attendance' => true,
                'view-attendances' => false,
                'update-attendances' => true,
                'activate-attendances' => false,
                'deactivate-attendances' => false,
                // end attendance
            ]),
        ]);
    }

}
