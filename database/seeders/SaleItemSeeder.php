<?php

namespace Database\Seeders;

use App\Models\Products\Company;
use App\Models\Products\MeasureUnit;
use App\Models\Products\MeasureUnitName;
use App\Models\Products\Product;
use App\Models\Refund\ReturnHeader;
use App\Models\Refund\ReturnItem;
use App\Models\Refund\WithDraw;
use App\Models\Sales\SaleHeader;
use App\Models\Sales\SaleItem;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleItemSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        $table->double('end_price');
//        $table->double('profit_price')->nullable();
//        $table->double('cost_price')->nullable();
//        $table->double('discount')->default(0);
//        $table->string('customer_name')->nullable();
        $headers = require 'database/seeders/data/sale_headers.php';
        foreach ($headers as $header) {
            SaleHeader::factory()->create([
                'end_price' => $header['end_price'],
                'profit_price' => 0,
                'cost_price' => $header['cost_price'],
                'discount' => $header['discount'],
                'customer_name' => $header['customer_name'],
                'created_at' => $header['created_at'],
                'updated_at' => $header['updated_at'],
            ])->items()->createMany($header['items']);
        }
        $a = file_exists('database/seeders/data/sale_headers2.php');
        if ($a) {
            $headers = require 'database/seeders/data/sale_headers2.php';
            foreach ($headers as $header) {
                SaleHeader::factory()->create([
                    'end_price' => $header['end_price'],
                    'profit_price' => 0,
                    'cost_price' => $header['cost_price'],
                    'discount' => $header['discount'],
                    'customer_name' => $header['customer_name'],
                    'created_at' => $header['created_at'],
                    'updated_at' => $header['updated_at'],
                ])->items()->createMany($header['items']);
            }
        }
        $returns = require 'database/seeders/data/return_headers.php';
        ReturnHeader::factory()->createMany($returns);
        $items = require 'database/seeders/data/return_items.php';
        ReturnItem::factory()->createMany($items);

        if (file_exists('database/seeders/data/with_draws.php')) {

            $with_draws = require 'database/seeders/data/with_draws.php';
            WithDraw::factory()->createMany($with_draws);
        }



    }

}
