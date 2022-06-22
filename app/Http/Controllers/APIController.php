<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Place;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function getAllCategories() {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function showCategory(Category $category){
        $places = Place::where('category_id', '=' , $category->id)->with('category')->get();

        return response()->json($places);
    }

}
