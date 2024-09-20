<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    // $table->string('name')->nullable();
    // $table->string('email')->unique();
    // $table->timestamp('email_verified_at')->nullable();
    // $table->string('password');

    // $table->enum('session',['Online','Offline'])->default('Offline');
    // $table->enum('user_types',['Admin','District','Areas','Branch'])->nullable();

    // $table->string('avatar');
    // $table->date('dob');
    // $table->rememberToken();

    // $table->unsignedBigInteger('user_group_id');
    // $table->unsignedBigInteger('company_id')->nullable();
    // $table->unsignedBigInteger('branch_id')->nullable();
    // $table->unsignedBigInteger('district_code_id')->nullable();
    // $table->unsignedBigInteger('area_code_id')->nullable();

    // $table->foreign('user_group_id')->references('id')->on('tbl_user_groups')->onDelete('restrict')->onUpdate('cascade');
    // $table->foreign('company_id')->references('id')->on('tbl_companies')->onDelete('restrict')->onUpdate('cascade');
    // $table->foreign('branch_id')->references('id')->on('tbl_branches')->onDelete('restrict')->onUpdate('cascade');
    // $table->foreign('district_code_id')->references('id')->on('tbl_districts')->onDelete('restrict')->onUpdate('cascade');
    // $table->foreign('area_code_id')->references('id')->on('tbl_areas')->onDelete('restrict')->onUpdate('cascade');

    public function run()
    {
        $faker = Faker::create();
            $data = [
                    [
                        'name' => 'Developer',
                        'email' => 'dev@gmail.com',
                        'password' => '$2y$12$Y0/wCO5ghJDL.DHsRaxOyOpByhTEv9z03pxZEcsKJjgh1JZL1Vn36',
                        'session' => 'Offline',
                        'user_types' => 'Developer',
                        'email_verified_at' => Carbon::now(),
                        'dob' => Carbon::now(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'user_group_id' => 1,
                        'company_id' => 1,
                        'branch_id' => NULL,
                        'district_code_id' => NULL,
                        'area_code_id' => NULL,
                    ],
                    [
                        'name' => 'Admin',
                        'email' => 'admin@gmail.com',
                        'password' => '$2y$12$Y0/wCO5ghJDL.DHsRaxOyOpByhTEv9z03pxZEcsKJjgh1JZL1Vn36',
                        'session' => 'Offline',
                        'user_types' => 'Admin',
                        'email_verified_at' => Carbon::now(),
                        'dob' => Carbon::now(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'user_group_id' => 2,
                        'company_id' => 1,
                        'branch_id' => NULL,
                        'district_code_id' => NULL,
                        'area_code_id' => NULL,
                    ],
                    [
                        'name' => 'Everfirst Admin',
                        'email' => 'everfirst_admin@gmail.com',
                        'password' => '$2y$12$Y0/wCO5ghJDL.DHsRaxOyOpByhTEv9z03pxZEcsKJjgh1JZL1Vn36',
                        'session' => 'Offline',
                        'user_types' => 'Admin',
                        'email_verified_at' => Carbon::now(),
                        'dob' => Carbon::now(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
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
