<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
 
    public function index()
    {
        $employees = Employee::search()->get();
        return responseJson(1 , 'success' , $employees);
    }

    public function store(Request $request)
    {
        $rules = [
            'name'         => 'required|max:255',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'nullable|max:255',
            'joining_date' => 'nullable|date|date_format:Y-m-d',
            'salary'       => 'nullable|numeric',
            'nid'          => 'max:255',
            //'image'        => 'nullable|image'
        ];
        $validator = validator()->make($request->all() , $rules );

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() ,  $validator->errors() );
        }

        $employee = Employee::create($request->all());

        $employee->uploadImage('employees');

        return responseJson(1 , 'Employee is added successfully');
    }

    public function show($id)
    {
        $employee = Employee::find($id);
        if(!$employee)
        {
            return responseJson(0 , 'No Employee Data');
        }

        return responseJson(1 , 'success' , $employee);
    }

  
    public function update(Request $request, $id)
    {
        $rules = [
            'name'         => 'required|max:255',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'nullable|max:255',
            'joining_date' => 'nullable|date|date_format:Y-m-d',
            'salary'       => 'nullable|numeric',
            'nid'          => 'max:255',
            //'image'        => 'nullable|image'
        ];
        $validator = validator()->make($request->all() , $rules );

        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() ,  $validator->errors() );
        }

        $employee = Employee::find($id);

        $employee->update($request->all());

        $employee->updateImage('employees');

        return responseJson(1 , 'Employee is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if(!$employee)
        {
            return responseJson(0 , 'No Employee Data');
        }

        $employee->deleteImage();
        $employee->delete();

        return responseJson(1 , 'Employee is deleted successfully');
    }
}
