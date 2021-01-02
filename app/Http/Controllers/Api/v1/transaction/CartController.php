<?php

namespace App\Http\Controllers\Api\v1\transaction;

use App\Http\Controllers\Api\v1\BaseController;
use App\Http\Resources\transaction\Cart as CartResource;
use App\Http\Resources\master\Product as ProductResource;
use App\Models\transaction\Cart;
use App\Models\master\Product;
use Illuminate\Http\Request;
use Str;
use DB;
use Validator;

class CartController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Cart::get();

        return $this->sendResponse(CartResource::collection($data), 'Data has been retrieved.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = [
            'product_uid' => $request->input('product_uid'),
            'price' => (int) $request->input('price'),
            'qty' => (int) $request->input('qty'),
        ];
        
        // Validate data request
        $validator = $this->_validationForm($input);
        if($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }

        // check stock available
        // check stock available
        $availableStock = $this->_checkAvailableStock($input['product_uid'], $input['qty']);
        if(!$availableStock) {
            return $this->sendError('Validation Error.', 'Product stock is not available', 400);       
        }

        DB::beginTransaction();
        try {
            $input['uid'] = Str::uuid();
            unset($input['product_uid']);
            
            $cart = Cart::create($input);
            
            // Assign Product ID to cart
            $product = Product::where('uid', $request->input('product_uid'))->first();
            $product->stock = Product::getAvailableStock($product); // get available stock 

            $cart->product_data = json_encode(new ProductResource($product));
            $cart->product()->associate($product);
            $cart->save();

            DB::commit(); // if there is no error, commit data to database
            return $this->sendResponse(new CartResource($cart), "{$product->name} has bedd added to cart.", 201);
        } catch (\Exception $e) {
            DB::rollback(); // if there is an error, rollback data from database
            // return $this->sendError('Internal Server Error.', 'Contact the administrator to tell about this error.', 500);
            return $this->sendError('Internal Server Error.', $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\transaction\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        $input = [
            'product_uid' => $request->input('product_uid'),
            'price' => (int) $request->input('price'),
            'qty' => (int) $request->input('qty'),
        ];
        
        // Validate data request
        $validator = $this->_validationForm($input, $cart);
        if($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }

        // check stock available
        $availableStock = $this->_checkAvailableStock($input['product_uid'], $input['qty'], $cart->qty);
        if(!$availableStock) {
            return $this->sendError('Validation Error.', 'Product stock is not available for that quantity.', 400);       
        }
        
        DB::beginTransaction();
        try {            
            $product = Product::where('id', $cart->product_id)->first();
            $product->stock = Product::getAvailableStock($product); // get available stock 

            $input['product_data'] = json_encode(new ProductResource($product));
            $cart->update($input);
            
            DB::commit(); // if there is no error, commit data to database
            return $this->sendResponse(new CartResource($cart), "Cart has been edited.");
        } catch (\Exception $e) {
            DB::rollback(); // if there is an error, rollback data from database
            return $this->sendError('Internal Server Error.', 'Contact the administrator to tell about this error.', 500);
            // return $this->sendError('Internal Server Error.', $cart, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\transaction\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $message = $cart->product ? "{$cart->product->name} has been deleted." : "Data has been deleted";
        $cart->delete();

        return $this->sendResponse([], $message);
    }

    /**
     * validate data from form request.
     *
     * @param array $input 
     * @param  \App\Models\transaction\Cart  $cart
     */
    private function _validationForm($input = [], $cart = null) {
        $rules = ['qty' => 'required|min:1|numeric'];
        if (!$cart) {
            $rules['product_uid'] = 'required|exists:'.Product::class.',uid';
            $rules['price'] = 'required|numeric';
        };
        return Validator::make($input, $rules);
    }

    /**
     * check available product stock
     *
     * @param string $productUid 
     * @param int $qty 
     * @param int $oldQty 
     * @return boolean
     */
    private function _checkAvailableStock($productUid = "", $qty = 0, $oldQty = 0) {
        $product = Product::where('uid', $productUid)->first();
        if($product) {
            $availableStock = Product::getAvailableStock($product) + $oldQty;
            if(($availableStock - $qty) < 0) return false;       
        }
        return true;
    }
}
