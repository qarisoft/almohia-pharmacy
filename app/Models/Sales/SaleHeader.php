<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleHeader extends Model
{
    /** @use HasFactory<\Database\Factories\Sales\SaleHeaderFactory> */
    use HasFactory;
    protected $fillable=[
        'end_price',
        'cost_price',
        'discount',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class,'header_id');
    }

    public function itemCount(): int
    {
        return $this->items()->sum('quantity');
    }


}
