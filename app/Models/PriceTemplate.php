<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'category',
        'pattern',
        'cost_price',
        'price',
    ];
}
