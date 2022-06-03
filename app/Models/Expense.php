<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeSearch($query)
    {
        return $query->where(function($q){

            if(request()->filled('search'))
            {
                $q->where('details' , 'like' , '%' . request()->search . '%')
                        ->orWhere('amount' , 'like' , '%' . request()->search . '%'); 
            }

            if(request()->filled('date'))
            {
                $q->where('date' ,  request()->date); 
            }

        });
   
    }
}
