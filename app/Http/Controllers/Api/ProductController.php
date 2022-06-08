<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
 
    public function index()
    {
        $products = Product::latest()->with('category:id,name' , 'supplier:id,name')->search()->get();
        return responseJson(1 , 'success' , $products);
    }

    public function store(Request $request)
    {
        $rules = [
            'name'         => 'required|max:255',
            'code'         => 'nullable|max:255',
            'category_id'  => 'required|exists:categories,id',
            'supplier_id'  => 'nullable|exists:suppliers,id',    
            'buying_price' => 'nullable|numeric',
            'selling_price'=> 'required|numeric',
            'quantity'     => 'required|numeric',
            //'image'        => 'nullable|image'
        ];
        $validator = validator()->make($request->all() , $rules );

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() ,  $validator->errors() );
        }

        $product = Product::create($request->all());

        $product->uploadImage('products');

        return responseJson(1 , 'product is added successfully');
    }

    public function show($id)
    {
        $product = Product::find($id);
        if(!$product)
        {
            return responseJson(0 , 'No product Data');
        }

        return responseJson(1 , 'success' , $product);
    }

  
    public function update(Request $request, $id)
    {
        $rules = [
            'name'         => 'required|max:255',
            'code'         => 'nullable|max:255',
            'category_id'  => 'required|exists:categories,id',
            'supplier_id'  => 'nullable|exists:suppliers,id',    
            'buying_price' => 'nullable|numeric',
            'selling_price'=> 'required|numeric',
            'quantity'     => 'required|numeric', 
            //'image'        => 'nullable|image'
        ];
        $validator = validator()->make($request->all() , $rules );

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() ,  $validator->errors() );
        }

        $product = Product::find($id);
        if(!$product)
        {
            return responseJson(0 , 'No product Data');
        }

        $product->update($request->all());

        $product->updateImage('products');

        return responseJson(1 , 'product is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if(!$product)
        {
            return responseJson(0 , 'No product Data');
        }

        $product->deleteImage();
        $product->delete();

        return responseJson(1 , 'product is deleted successfully');
    }
}
