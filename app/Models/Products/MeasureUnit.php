<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeasureUnit extends Model
{
    /** @use HasFactory<\Database\Factories\Products\MeasureUnitFactory> */
    use HasFactory;


    protected $guarded=[];



    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

//    public function unitName(): BelongsTo
//    {
//        return $this->belongsTo(MeasureUnitName::class,'measure_unit_name_id');
//    }
}
