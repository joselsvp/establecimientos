<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Place;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function getAllPlaces() {
        $places = Place::with('category')->get();

        return response()->json($places);
    }

    public function showPlace(Category $category){
        $places = Place::where('category_id', '=' , $category->id)->with('category')->get();

        return response()->json($places);
    }

}
