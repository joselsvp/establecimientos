<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //read image
        $url_image = $request->file('file')->store('places', 'public');

        //resize image
        $image = Image::make(public_path("storage/{$url_image}"))->fit(800, 450);
        $image->save();

        //storage with model
        $imageDB = new \App\Models\Image();
        $imageDB->id_place = $request['uuid'];
        $imageDB->url = $url_image;
        $imageDB->save();

        //return response
        $response = ['file' => $url_image];

        //associative object PHP to JSON JS
        return response()->json($response);
    }


    /**
     * Destroy image to server and database
     */
    public function destroy(Request $request)
    {
        $image = $request->get('image');
        if(File::exists('storage/' . $image)){
            File::delete('storage/' . $image);
        }

        $response = [
            'message' => 'Imagen eliminada',
            'image' => $image
        ];

        \App\Models\Image::where('url', '=', $image)->delete();
        return response()->json($response);
    }
}
