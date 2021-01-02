<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{    
    /**
     * Scope a query to only include active data.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
