<?php

namespace App\Models\Refund;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnHeader extends Model
{
    /** @use HasFactory<\Database\Factories\Refund\ReturnHeaderFactory> */
    use HasFactory;

    protected $fillable=['end_price'];
}
