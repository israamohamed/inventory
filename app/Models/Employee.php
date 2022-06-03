<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Images\HasAnImage;

class Employee extends Model
{
    use HasFactory, HasAnImage ;

    protected $guarded = ['id'];
    protected $appends = ['image_path'];

    public function scopeSearch($query)
    {
        return $query->where(function($q){

            if(request()->filled('search'))
            {
                $q->where('name' , 'like' , '%' . request()->search . '%')
                        ->orWhere('email' , 'like' , '%' . request()->search . '%')
                        ->orWhere('phone' , 'like' , '%' . request()->search . '%')
                        ->orWhere('nid' , 'like' , '%' . request()->search . '%')
                        ->orWhere('address' , 'like' , '%' . request()->search . '%');
                        
            }

        });
   
    }

    public function salaries()
    {
        return $this->hasMany('App\Models\Salary');
    }
    
    
}
