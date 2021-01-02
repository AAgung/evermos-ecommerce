<?php

namespace App\Http\Resources\master;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\master\Product as ProductModel;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uid' => $this->uid,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'category' => $this->category ? : null,
            'unit' => $this->unit ? : null,
            'price' => $this->price ? : 0,
            'stock' => ProductModel::getAvailableStock($this),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
