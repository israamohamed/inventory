<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Salary;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = Salary::with('employee')->latest()->search()->get();
        return responseJson(1 , 'success' , $salaries);
    }

    public function pay_salary(Request $request , $id)
    {
        $employee = Employee::find($id);
        if(!$employee)
        {
            return responseJson(0 , 'No Employee Data');
        }

        $rules = [
            'salary'      => 'required|numeric',
            'month'       => 'required|max:255',
            'year'        => 'required|max:255',
        ];

        $validator = validator()->make($request->all() , $rules );
        if($validator->fails())
        {
            return responseJson(0 , $validator->errors()->first() ,  $validator->errors() );
        }

        $exists = Salary::where('employee_id' , $id)->where('month' , $request->month)
                        ->where('year' , $request->year)
                        ->first();

        if($exists)
        {
            return responseJson(0 , 'Employee paid the salary for the same month before!');
        }

        $request->merge([
            'date'        => date("Y-m-d")
        ]);

        $salary = $employee->salaries()->create($request->all());

        return responseJson(1 , 'Salary is added successfully');
    }
}
