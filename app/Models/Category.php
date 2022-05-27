<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeSearch($query)
    {
        return $query->where(function($q){

            if(request()->filled('search'))
            {
                $q->where('name' , 'like' , '%' . request()->search . '%');
            }

        });
    }
}
