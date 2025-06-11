<?php

use App\Models\Products\MeasureUnit;
use App\Models\Products\MeasureUnitName;
use App\Models\Products\Product;
use App\Models\Store\ProductInput;
use App\Models\Store\ProductInputHeader;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    $a = ProductInput::query()->whereHas('header', function ($q) {
//        $q->where('bill_number', 670349);
//    })->get();

    // return $a;
    return  redirect('/sales/sales');
//    return view('welcome',['product_inputs'=>$a,'products'=>\App\Models\Products\Product::all()]);
});


Route::get('/products', function () {
    return view('products',[
        'data'=>Product::all()
    ]);
});


Route::get('/units', function () {
    return view('units',[
        'data'=>MeasureUnit::all()
    ]);
});
Route::get('/product-header', function () {
    return view('product-header',[
        'data'=>ProductInputHeader::all()
    ]);
});
Route::get('/product-input', function () {
    return view('product-input',[
        'data'=>ProductInput::all()
    ]);
});
Route::get('/unit-name', function () {
    return view('unit-name',[
        'data'=>MeasureUnitName::all()
    ]);
});
