<?php

use App\Models\Store\ProductInput;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $a = ProductInput::query()->whereHas('header', function ($q) {
        $q->where('bill_number', 670349);
    })->get();

    // return $a;
    return  redirect('/sales/sales');
    return view('welcome',['product_inputs'=>$a,'products'=>\App\Models\Products\Product::all()]);
});
