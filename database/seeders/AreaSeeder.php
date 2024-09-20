<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AreaSeeder extends Seeder
{
    public function run()
    {
            $data = [
                        [
                            'area_no' => 'A1',
                            'area_name' => 'Josephine Julio',
                            'email' => 'jrjulio@everfirstloans.com',
                            'district_id' => 1,
                            'status' => 1,
                            'company_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'area_no' => 'A2',
                            'area_name' => 'Cecillia Ibarra',
                            'email' => 'ceborgonos@everfirstloans.com',
                            'district_id' => 1,
                             'status' => 1,
                            'company_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'area_no' => 'A1',
                            'area_name' => 'Maricar Yacat',
                            'email' => 'mdyacat@everfirstloans.com',
                            'district_id' => 2,
                             'status' => 1,
                            'company_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'area_no' => 'A2',
                            'area_name' => 'Hyazel Cajipe',
                            'email' => 'hscajipe@everfirstloans.com',
                            'district_id' => 2,
                             'status' => 1,
                            'company_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'area_no' => 'A1',
                            'area_name' => 'Minerva Piga',
                            'email' => 'kroliva@everfirstloans.com',
                            'district_id' => 3,
                             'status' => 1,
                            'company_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'area_no' => 'A2',
                            'area_name' => 'Imelda Estipona',
                            'email' => 'imestipona@everfirstloans.com',
                            'district_id' => 3,
                             'status' => 1,
                            'company_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'area_no' => 'A1',
                            'area_name' => 'Hobert M Santiago',
                            'email' => 'hmsantiago@everfirstloans.com',
                            'district_id' => 4,
                             'status' => 1,
                            'company_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'area_no' => 'A2',
                            'area_name' => 'Diana Rose Garbin',
                            'email' => 'dsgarbin@everfirstloans.com',
                            'district_id' => 4,
                             'status' => 1,
                            'company_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'area_no' => 'A1',
                            'area_name' => 'Kayneth Joy Vigare',
                            'email' => 'ksvigare@everfirstloans.com',
                            'district_id' => 5,
                             'status' => 1,
                            'company_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'area_no' => 'A2',
                            'area_name' => 'Jocelyn Dela Cruz',
                            'email' => 'jmdelacruz@everfirstloans.com',
                            'district_id' => 5,
                             'status' => 1,
                            'company_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'area_no' => 'A1',
                            'area_name' => 'Marcelito Selda',
                            'email' => 'mtselda@everfirstloans.com',
                            'district_id' => 6,
                             'status' => 1,
                            'company_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],
                        [
                            'area_no' => 'A2',
                            'area_name' => 'Armida Jatap',
                            'email' => 'apjatap@everfirstloans.com',
                            'district_id' => 6,
                            'status' => 1,
                            'company_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ],

                    ];
            DB::table('tbl_areas')->insert($data);
    }
}
