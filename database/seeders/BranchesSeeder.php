<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BranchesSeeder extends Seeder
{
    public function run()
    {
            $data = [
                        [
                            'district_id' => NULL,
                            'area_id' => NULL,
                            'branch_abbreviation' => 'AD',
                            'branch_location' => 'Admin',
                            'branch_head' => '',
                            'company_id' => 1,
                            'status' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'district_id' => NULL,
                            'area_id' => NULL,
                            'branch_abbreviation' => NULL,
                            'branch_location' => 'FMC Main',
                            'branch_head' => '',
                            'company_id' => 2,
                            'status' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'district_id' => NULL,
                            'area_id' => NULL,
                            'branch_abbreviation' => NULL,
                            'branch_location' => 'Calderon',
                            'branch_head' => '',
                            'company_id' => 2,
                            'status' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'district_id' => NULL,
                            'area_id' => NULL,
                            'branch_abbreviation' => NULL,
                            'branch_location' => 'Audit',
                            'branch_head' => '',
                            'company_id' => 2,
                            'status' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'district_id' => 6,
                            'area_id' => 12,
                            'branch_abbreviation' => 'AL',
                            'branch_location' => 'Alabang',
                            'branch_head' => 'Lucia Galanto',
                            'company_id' => 2,
                            'status' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'district_id' => 1,
                            'area_id' => 1,
                            'branch_abbreviation' => 'AG',
                            'branch_location' => 'Angeles',
                            'branch_head' => 'Micah Bunenaobra',
                            'company_id' => 2,
                            'status' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'district_id' => 4,
                            'area_id' => 7,
                            'branch_abbreviation' => 'AR',
                            'branch_location' => 'Angono',
                            'branch_head' => 'Geraldine Maravilla',
                            'company_id' => 2,
                            'status' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'district_id' => 1,
                            'area_id' => 1,
                            'branch_abbreviation' => 'AP',
                            'branch_location' => 'Apalit',
                            'branch_head' => 'Diane Eve Muyo',
                            'company_id' => 2,
                            'status' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'district_id' => 5,
                            'area_id' => 10,
                            'branch_abbreviation' => 'BA',
                            'branch_location' => 'Baclaran',
                            'branch_head' => 'Ronio Arcilla',
                            'company_id' => 2,
                            'status' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'district_id' => 2,
                            'area_id' => 3,
                            'branch_abbreviation' => 'BS',
                            'branch_location' => 'Bagong Silang',
                            'branch_head' => 'Rochelle Fuster',
                            'company_id' => 2,
                            'status' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                    ];
            DB::table('tbl_branches')->insert($data);
    }
}
