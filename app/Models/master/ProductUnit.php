<?php

namespace App\Models\master;

use App\Models\Base as BaseModel;

class ProductUnit extends BaseModel
{
    protected $table = 'm_product_unit';
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
