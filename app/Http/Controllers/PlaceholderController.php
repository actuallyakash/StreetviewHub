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
        // q (query)
        if ( $request->query('q') ) {
            $query = $request->query('q');
            $match = $request->query('m');
            $image = $match == "" ? $this->search( $query ) : $this->search( $query, $match );
        } else {
            $image = $this->random(); // Random
        }
        
        // Sized
        if ( $request->size ) {
            $size = $this->getSize( $request->size );
            $resized = $image->resize( $size[0], $size[1] );
        }

        return $image->response();
    }

    public function random()
    {
        $media = Storage::disk('s3')->url( Location::inRandomOrder()->first()->media );

        return Image::make($media);
    }

    public function getSize( $size )
    {
        if ( strpos( $size, "x" ) ) {
            $resized = explode( "x", $size );
        } else {
            $resized = array( $size, $size );
        }

        return $resized;
    }

    public function randomWithSize( Request $request )
    {
        $size = $this->getSize( $request->size );

        $random = $this->random();

        $resized = $random->resize( $size[0], $size[1] );

        return $resized;
    }
    
    public function search( $query, $match = "loose" )
    {
        if ( $match == "strict" ) {

            // Only based on tags
            $eyeshots = Location::whereRaw("if(FIND_IN_SET(?, tags) > 0, true, false)", [$query])->get();

        } else {

            // (Loose) Based on tags and location name
            $eyeshotsByTags = Location::whereRaw("if(FIND_IN_SET(?, tags) > 0, true, false)", [$query])->get();
            $eyeshotsByLocationName = Location::where("location_name", "like", "%$query%")->get();
            $eyeshots = $eyeshotsByTags->merge($eyeshotsByLocationName);

        }

        $media = Storage::disk('s3')->url( $eyeshots->random()->media );
            
        return Image::make($media);
    }
}
