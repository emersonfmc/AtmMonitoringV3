<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
            $data = [
                    [
                        'name' => 'Developer',
                        'employee_id' => '000001',
                        'email' => 'dev@gmail.com',
                        'password' => '$2y$12$Y0/wCO5ghJDL.DHsRaxOyOpByhTEv9z03pxZEcsKJjgh1JZL1Vn36',
                        'session' => 'Offline',
                        'user_types' => 'Developer',
                        'email_verified_at' => Carbon::now(),
                        'dob' => Carbon::now(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'status' => 'Active',
                        'user_group_id' => 1,
                        'company_id' => 1,
                        'branch_id' => NULL,
                        'district_code_id' => NULL,
                        'area_code_id' => NULL,
                    ],
                    [
                        'name' => 'Admin',
                        'employee_id' => '000002',
                        'email' => 'admin@gmail.com',
                        'password' => '$2y$12$Y0/wCO5ghJDL.DHsRaxOyOpByhTEv9z03pxZEcsKJjgh1JZL1Vn36',
                        'session' => 'Offline',
                        'user_types' => 'Admin',
                        'email_verified_at' => Carbon::now(),
                        'dob' => Carbon::now(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'status' => 'Active',
                        'user_group_id' => 2,
                        'company_id' => 1,
                        'branch_id' => NULL,
                        'district_code_id' => NULL,
                        'area_code_id' => NULL,
                    ],
                    [
                        'name' => 'Everfirst Admin',
                        'employee_id' => '000003',
                        'email' => 'everfirst_admin@gmail.com',
                        'password' => '$2y$12$Y0/wCO5ghJDL.DHsRaxOyOpByhTEv9z03pxZEcsKJjgh1JZL1Vn36',
                        'session' => 'Offline',
                        'user_types' => 'Admin',
                        'email_verified_at' => Carbon::now(),
                        'dob' => Carbon::now(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'status' => 'Active',
                        'user_group_id' => 3,
                        'company_id' => 2,
                        'branch_id' => NULL,
                        'district_code_id' => NULL,
                        'area_code_id' => NULL,
                    ],
                    // [
                    //     'name' => 'Lucia Galanto',
                    //     'email' => 'alabang@everfirst.com',
                    //     'password' => '$2y$12$Y0/wCO5ghJDL.DHsRaxOyOpByhTEv9z03pxZEcsKJjgh1JZL1Vn36',
                    //     'session' => 'Offline',
                    //     'user_types' => 'Branch',
                    //     'email_verified_at' => Carbon::now(),
                    //     'dob' => Carbon::now(),
                    //     'created_at' => Carbon::now(),
                    //     'updated_at' => Carbon::now(),
                    //     'user_group_id' => 6,
                    //     'company_id' => 2,
                    //     'branch_id' => 5,
                    //     'district_code_id' => 6,
                    //     'area_code_id' => 12,
                    // ],
                    // [
                    //     'name' => 'John Cris Calatcat',
                    //     'email' => 'chriscalatcat@gmail.com',
                    //     'password' => '$2y$12$Y0/wCO5ghJDL.DHsRaxOyOpByhTEv9z03pxZEcsKJjgh1JZL1Vn36',
                    //     'session' => 'Offline',
                    //     'user_types' => 'Branch',
                    //     'email_verified_at' => Carbon::now(),
                    //     'dob' => Carbon::now(),
                    //     'created_at' => Carbon::now(),
                    //     'updated_at' => Carbon::now(),
                    //     'user_group_id' => 10,
                    //     'company_id' => 2,
                    //     'branch_id' => 5,
                    //     'district_code_id' => 6,
                    //     'area_code_id' => 12,
                    // ],
        ];
            DB::table('users')->insert($data);
    }
}
