<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'code',
        'category_id',
        'price',
        'cost_price',
        'stock',
        'image',
        'payment_status',
        'customer_name',
        'created_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
