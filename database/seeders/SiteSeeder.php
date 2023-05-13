<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sites = [
            ['name' => 'BEI', 'slug' => 'bei', 'status' => 'Active'],
            ['name' => 'JMII', 'slug' => 'jmii', 'status' => 'Active'],
            ['name' => 'ALTICE', 'slug' => 'altice', 'status' => 'Active'],
            ['name' => 'intesa', 'slug' => 'intesa', 'status' => 'Active'],
            ['name' => 'chandigarh', 'slug' => 'chandigarh', 'status' => 'Active'],
            ['name' => 'Mohali', 'slug' => 'mohali', 'status' => 'Active'],
        ];

        Site::insert($sites);
    }
}
