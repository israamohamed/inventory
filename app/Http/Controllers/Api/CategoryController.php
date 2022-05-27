<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
 
    public function index()
    {
        $categories = Category::search()->get();
        return responseJson(1 , 'success' , $categories);
    }

    public function store(Request $request)
    {
        $rules = [
            'name'         => 'required|max:255',
        ];
        $validator = validator()->make($request->all() , $rules );

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() ,  $validator->errors() );
        }

        $category = Category::create($request->all());

        return responseJson(1 , 'Category is added successfully');
    }

    public function show($id)
    {
        $category = Category::find($id);
        if(!$category)
        {
            return responseJson(0 , 'No Category Data');
        }

        return responseJson(1 , 'success' , $category);
    }

  
    public function update(Request $request, $id)
    {
        $rules = [
            'name'         => 'required|max:255',
        ];
        $validator = validator()->make($request->all() , $rules );

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() ,  $validator->errors() );
        }

        $category = Category::find($id);
        
        if(!$category)
        {
            return responseJson(0 , 'No Category Data');
        }

        $category->update($request->all());

        return responseJson(1 , 'Category is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if(!$category)
        {
            return responseJson(0 , 'No Category Data');
        }

        $category->delete();

        return responseJson(1 , 'Category is deleted successfully');
    }
}
