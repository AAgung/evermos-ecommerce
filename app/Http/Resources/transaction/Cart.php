<?php

namespace App\Http\Resources\transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class Cart extends JsonResource
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
            'product' => $this->product ? : ($this->product_data ? json_decode($this->product_data) : null),
            'price' => $this->price ? : 0,
            'qty' => $this->qty ? : 0,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
