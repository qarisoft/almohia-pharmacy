<?php

namespace App\Models\Products;

use App\Models\Store\ProductInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MeasureUnit extends Model
{
    /** @use HasFactory<\Database\Factories\Products\MeasureUnitFactory> */
    use HasFactory;


    protected $guarded = [];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function sellPrice(): float
    {
        return ($this->product?->unit_price * $this->count) - $this->discount;
    }

    public function cost(): HasOne
    {
        return $this->hasOne(ProductInput::class, 'unit_id');
    }

    public function isCost(): bool
    {
        return $this->cost()->exists();
    }


    public function costPrice(?int $unit_cost_price=null)
    {
        $s = $this->product?->lastStoreItem;
        if ($s) {
            $a = $unit_cost_price?? $s->unit_cost_price;
            if ($s->unit()->exists()) {
                return ($a / $s->unit->count) * $this->count;
            }
            return  $a;
        }
        return 0;

    }


    public function profit()
    {
        return $this->sellPrice() - $this->costPrice();
    }

}
