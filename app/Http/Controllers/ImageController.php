<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
