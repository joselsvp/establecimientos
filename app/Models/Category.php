<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //read routes by slug
    public function getRouteKeyName()
    {
        return 'slug';
    }

    //relation one to many category and places
    public function places(){
        return $this->hasMany(Place::class);
    }
}
