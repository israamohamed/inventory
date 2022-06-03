<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeSearch($query)
    {
        return $query->where(function($q){

            if(request()->filled('search'))
            {
                $q->where('salary' , 'like' , '%' . request()->search . '%'); 
            }

            if(request()->filled('year'))
            {
                $q->where('year' ,  request()->year); 
            }

            if(request()->filled('month'))
            {
                $q->where('month' ,  request()->month); 
            }

            if(request()->filled('date'))
            {
                $q->whereDate('date' ,  request()->date); 
            }

            if(request()->filled('employee_id'))
            {
                $q->where('employee_id' ,  request()->employee_id); 
            }

        });
   
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }


}
