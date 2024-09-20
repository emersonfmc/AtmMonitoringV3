<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CompanySeeder::class,
            DistrictSeeder::class,
            UserGroupSeeder::class,
            UserSeeder::class,
            AreaSeeder::class,
            BranchesSeeder::class,
            AtmBanksSeeder::class,
            AtmPensionTypesSeeder::class,


        ]);
    }
}
