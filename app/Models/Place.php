<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'image',
        'country',
        'address',
        'neighborhood',
        'postal_code',
        'phone',
        'description',
        'opening',
        'latitude',
        'longitude',
        'close',
        'uuid',
        'user_id'
    ];

    //table places have category_id, then Category::class belongs to category
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
