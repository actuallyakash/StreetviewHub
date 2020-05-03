<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Location;

class PlaceholderController extends Controller
{
    public function api( Request $request )
    {
        $image = $this->{$request->task}($request);

        return $image->response();
    }

    public function random()
    {
        $media = Storage::disk('s3')->url( Location::inRandomOrder()->first()->media );

        return Image::make($media);
    }

    public function randomWithSize( Request $request )
    {
        if ( strpos( $request->size, "x" ) ) {
            $size = explode( "x", $request->size );
        } else {
            $size = array( $request->size, $request->size );
        }

        $random = $this->random();

        $resized = $random->resize( $size[0], $size[1] );

        return $resized;
    }
}
