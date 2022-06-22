<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Place;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PlaceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('places.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
           'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|max:1000',
            'country' => 'required',
            'address' => 'required',
            'neighborhood' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'postal_code' => 'required',
            'phone' => 'required|numeric',
            'description' => 'required|min:50',
            'opening' => 'date_format:H:i',
            'close' => 'date_format:H:i|after:opening',
            'uuid' => 'required|uuid',
        ]);
        //save img
        $url_image = $request['image']->store('main', 'public');

        //resize image
        $img = Image::make(public_path("storage/{$url_image}"))->fit(800, 600);
        $img->save();

        /*/save all data DB
        auth()->user()->place()->create([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'image' => $data['image'],
            'country' => $data['country'],
            'address' => $data['address'],
            'neighborhood' => $data['neighborhood'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'postal_code' => $data['postal_code'],
            'phone' => $data['phone'],
            'description' => $data['description'],
            'opening' => $data['opening'],
            'close' => $data['close'],
            'uuid' => $data['uuid'],
        ]);
        */
        //onother way to save data
        $place = new Place($data);
        $place->image = $url_image;
        $place->user_id = auth()->user()->id;
        $place->save();

        dd('guardado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        return 'desde edit';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        //
    }
}
