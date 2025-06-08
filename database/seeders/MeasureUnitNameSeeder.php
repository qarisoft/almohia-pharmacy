<?php

namespace Database\Seeders;

use App\Models\Products\Company;
use App\Models\Products\MeasureUnitName;
use App\Models\Products\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeasureUnitNameSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        MeasureUnitName::factory()->createMany([
            ['name'=>'باكت'],
            ['name'=>'امبولة'],
            ['name'=>'قربة'],
            ['name'=>'فيالة'],
            ['name'=>'شريط'],
            ['name'=>'زجاجة'],
            ['name'=>'كرتون'],
            ['name'=>'حبة'],
            ['name'=>'شدة'],
        ]);

    }
}
