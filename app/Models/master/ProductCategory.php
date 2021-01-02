<?php

namespace App\Models\master;

use App\Models\Base as BaseModel;

class ProductCategory extends BaseModel
{
    protected $table = 'm_product_category';
    protected $fillable = [
        'uid',
        'name',
        'slug',
        'active',
    ];

    public function getRouteKeyName() 
    {
        return 'uid';
    }
}
