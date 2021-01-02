<?php

namespace App\Models\master;

use App\Models\master\ProductCategory;
use App\Models\master\ProductUnit;
use App\Models\Base as BaseModel;

class Product extends BaseModel
{
    protected $table = 'm_product';
    protected $fillable = [
        'uid',
        'name',
        'slug',
        'description',
        'category_id',
        'unit_id',
        'price',
        'stock',
        'active',
    ];

    public function getRouteKeyName() 
    {
        return 'uid';
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function unit()
    {
        return $this->belongsTo(ProductUnit::class, 'unit_id');
    }
}
