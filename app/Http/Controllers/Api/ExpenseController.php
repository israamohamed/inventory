<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
 
    public function index()
    {
        $expenses = Expense::search()->orderBy('created_at' , 'desc')->get();
        return responseJson(1 , 'success' , $expenses);
    }

    public function store(Request $request)
    {
        $rules = [
            'amount'         => 'required|numeric',
            'details'        => '',
        ];
        $validator = validator()->make($request->all() , $rules );

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() ,  $validator->errors() );
        }

        $request->merge([
            'date' => date("Y-m-d")
        ]);
        $expense = Expense::create($request->all());

        return responseJson(1 , 'Expense is added successfully');
    }

    public function show($id)
    {
        $expense = Expense::find($id);
        if(!$expense)
        {
            return responseJson(0 , 'No expense Data');
        }

        return responseJson(1 , 'success' , $expense);
    }

  
    public function update(Request $request, $id)
    {
        $rules = [
            'amount'         => 'required|numeric',
            'details'        => '',
        ];
        $validator = validator()->make($request->all() , $rules );

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() ,  $validator->errors() );
        }

        $expense = Expense::find($id);
        
        if(!$expense)
        {
            return responseJson(0 , 'No expense Data');
        }

        $expense->update($request->all());

        return responseJson(1 , 'expense is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        if(!$expense)
        {
            return responseJson(0 , 'No expense Data');
        }

        $expense->delete();

        return responseJson(1 , 'expense is deleted successfully');
    }
}
