<?php

namespace App\Models\transaction;

use App\Models\master\Product;
use App\Models\Base as BaseModel;

class Cart extends BaseModel
{
    protected $table = 't_cart';
    protected $fillable = [
        'uid',
        'product_id',
        'product_data',
        'price',
        'qty',
    ];

    public function getRouteKeyName() 
    {
        return 'uid';
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
