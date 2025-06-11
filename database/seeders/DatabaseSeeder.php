<?php

namespace Database\Seeders;

use App\Models\Products\MeasureUnit;
use App\Models\Products\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Salah',
            'email' => 'salah@t.t',
            'is_admin' => true,
        ]);
        User::factory()->create([
            'name' => 'User 1',
            'email' => 'user@t.t',
        ]);



        $this->call(MeasureUnitNameSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(MeasureUnitSeeder::class);
        $this->call(ProductInputSeeder::class);
        $this->call(SaleItemSeeder::class);
//        Product::all()->each(function (Product $product) {
//            $units = $product->units;
//            foreach ($units as $unit) {
//                $fr = 0;
//
////                if ($unit->isCost()) {
////                    $fr=1;
////                }
//            }
//        });
//        MeasureUnit::all()->each(function (MeasureUnit $unit) {
//
//
//        });





//        $this->call(Bill1525::class);



//        $p=Product::factory()->create(['name_ar'=>'dsd','sell_price'=>10]);
//        SaleHeader::factory()->make();


    }
}
