<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
 
    public function index()
    {
        $suppliers = Supplier::search()->get();
        return responseJson(1 , 'success' , $suppliers);
    }

    public function store(Request $request)
    {
        $rules = [
            'name'         => 'required|max:255',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'nullable|max:255',
            'shop_name'    => 'nullable|max:255',      
            //'image'        => 'nullable|image'
        ];
        $validator = validator()->make($request->all() , $rules );

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() ,  $validator->errors() );
        }

        $supplier = Supplier::create($request->all());

        $supplier->uploadImage('suppliers');

        return responseJson(1 , 'supplier is added successfully');
    }

    public function show($id)
    {
        $supplier = Supplier::find($id);
        if(!$supplier)
        {
            return responseJson(0 , 'No supplier Data');
        }

        return responseJson(1 , 'success' , $supplier);
    }

  
    public function update(Request $request, $id)
    {
        $rules = [
            'name'         => 'required|max:255',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'nullable|max:255',
            'shop_name'    => 'nullable|max:255',      
            //'image'        => 'nullable|image'
        ];
        $validator = validator()->make($request->all() , $rules );

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() ,  $validator->errors() );
        }

        $supplier = Supplier::find($id);
        if(!$supplier)
        {
            return responseJson(0 , 'No supplier Data');
        }

        $supplier->update($request->all());

        $supplier->updateImage('suppliers');

        return responseJson(1 , 'supplier is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        if(!$supplier)
        {
            return responseJson(0 , 'No supplier Data');
        }

        $supplier->deleteImage();
        $supplier->delete();

        return responseJson(1 , 'supplier is deleted successfully');
    }
}
