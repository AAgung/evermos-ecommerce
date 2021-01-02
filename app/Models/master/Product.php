<?php

namespace App\Models\master;

use App\Models\master\ProductCategory;
use App\Models\master\ProductUnit;
use App\Models\transaction\Cart;
use App\Models\Base as BaseModel;
use DB;

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

    
    /**
     * get available stock product (calculate from stock in table t_barang - total qty in table t_cart that still in order)
     * @param object $product
     * @return int 
     */
    public static function getAvailableStock($product = null) 
    {
        $stockAvailable = 0;
        if($product) {
            $productStock = Product::where('id', $product->id)->select('stock')->first();
            $productQtyOnOrder = Cart::where('product_id', $product->id)->select(DB::raw('SUM(qty) qty'))->first();
            $stockAvailable = ($productStock ? $productStock->stock : 0) - ($productQtyOnOrder ? $productQtyOnOrder->qty : 0);
        }
        return $stockAvailable;
    }
}
