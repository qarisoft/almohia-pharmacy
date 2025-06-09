<?php

namespace App\Models\Sales;

use App\Models\Products\MeasureUnit;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    /** @use HasFactory<\Database\Factories\Sales\SaleItemFactory> */
    use HasFactory;
    protected $guarded=[];
//    protected $fillable=[
//        'product_id',
//        'header_id',
//        'quantity',
//        'end_price',
//        'product_price',
//    ];


    public function header(): BelongsTo
    {
        return $this->belongsTo(SaleHeader::class,'header_id');
    }

    public function product(): BelongsTo
    {
        return   $this->belongsTo(Product::class);
    }


    public function unit(): BelongsTo
    {
        return $this->belongsTo(MeasureUnit::class,'unit_id');
    }

}
