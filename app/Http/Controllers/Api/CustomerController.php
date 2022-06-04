<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
 
    public function index()
    {
        $customers = Customer::latest()->search()->get();
        return responseJson(1 , 'success' , $customers);
    }

    public function store(Request $request)
    {
        $rules = [
            'name'         => 'required|max:255',
            'email'        => 'nullable|email|max:255|unique:customers,email',
            'phone'        => 'nullable|max:255|unique:customers,phone',
            'address'      => 'nullable',      
        ];
        $validator = validator()->make($request->all() , $rules );

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() ,  $validator->errors() );
        }

        $customer = Customer::create($request->all());

        return responseJson(1 , 'customer is added successfully');
    }

    public function show($id)
    {
        $customer = Customer::find($id);
        if(!$customer)
        {
            return responseJson(0 , 'No customer Data');
        }

        return responseJson(1 , 'success' , $customer);
    }

  
    public function update(Request $request, $id)
    {
        $rules = [
            'name'         => 'required|max:255',
            'email'        => 'nullable|email|max:255|unique:customers,email,' . $id,
            'phone'        => 'nullable|max:255|unique:customers,phone,' . $id,
            'address'      => 'nullable',   
        ];
        $validator = validator()->make($request->all() , $rules );

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() ,  $validator->errors() );
        }

        $customer = Customer::find($id);
        if(!$customer)
        {
            return responseJson(0 , 'No customer Data');
        }

        $customer->update($request->all());

        return responseJson(1 , 'customer is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if(!$customer)
        {
            return responseJson(0 , 'No customer Data');
        }
        $customer->delete();

        return responseJson(1 , 'customer is deleted successfully');
    }
}
