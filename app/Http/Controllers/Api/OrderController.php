<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use DB;

class OrderController extends Controller
{
   
    public function index()
    {
        $orders = Order::latest()->search()->get();
        return responseJson(1 , 'success' , $orders);
    }


    public function store(Request $request)
    {
        $rules = [
            'customer_id'          => 'required|exists:customers,id',
            'discount'             => 'nullable|numeric',
            'products'             => 'required|array',
            'products.*.id'        => 'required|exists:products,id|distinct',
            'products.*.quantity'  => 'required|numeric',
        ];

        $validator = validator()->make($request->all() , $rules);

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() , $validator->errors());
        }

        $request->merge(['date' => date("Y-m-d")]);

        DB::beginTransaction();
        $order = Order::create($request->all());
        foreach($request->products as $item)
        {
            $product = Product::find($item['id']);
            if($product->quantity <  $item['quantity']) //stock < required
            {
                DB::rollBack();
                return responseJson(0 , $product->name . ' has only ' . $product->quantity . ' in the stock');
            }

            $order->products()->attach($product->id , [
                'price' => $product->selling_price,
                'quantity' => $item['quantity'],
            ]);

            $product->update(['quantity' => $product->quantity - $item['quantity']   ]);

        }
        DB::commit();
        return responseJson(1 , 'Order is saved successfully');
    }

  
    public function show($id)
    {
        $order = Order::with('customer' , 'products')->find($id);
        if(!$order)
        {
            return responseJson(0 , 'No Order Data');
        }

        return responseJson(1 , 'success' , $order);
    }

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
