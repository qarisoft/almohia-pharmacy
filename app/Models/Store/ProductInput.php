<?php

namespace App\Models\Store;

use App\Models\Products\Product;
use App\PaymentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductInput extends Model
{
    /** @use HasFactory<\Database\Factories\Store\ProductInputFactory> */
    use HasFactory;

    protected $casts=[
        'payment_type'=>PaymentType::class,
    ];


    protected $fillable=[
        'product_id',
        'quantity',
        'unit_cost_price',
        'total_cost_price',
        'expire_date',
        'vendor_id'
    ];


    public function product(): BelongsTo
    {
        return  $this->belongsTo(Product::class);
    }

    public function vendor(): BelongsTo
    {
        return  $this->belongsTo(Vendor::class);
    }

    public function header(): BelongsTo
    {
        return $this->belongsTo(ProductInputHeader::class, 'header_id');
    }


}
