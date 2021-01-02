<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseController;
use App\Http\Resources\master\Product as ProductResource;
use App\Models\master\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::active()->get();

        return $this->sendResponse(ProductResource::collection($data), 'Data has been retrieved.');
    }
}
