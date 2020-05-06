<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Location;
use Helper;

class PlaceholderController extends Controller
{
    public function api( Request $request )
    {
        if ( $request->query('q') ) {
            // Get Searched Image
            $query = $request->query('q');
            $match = $request->query('m');
            $user = $request->query('u');
            $image = $this->search( $query, $match, $user );
        } elseif ( $request->query( 'id' ) ) {
            // Get Image by ID
            $image = $this->imageById( $request->query( 'id' ) );
        } else {
            // Get Random Image
            $image = $this->random( $request->query('u') );
        }
        
        // Sized
        if ( $request->size ) {
            $size = $this->getSize( $request->size );
            
            $image->resize( $size[0], $size[1] );
        }

        // Blur
        if ( $request->query( 'blur' ) ) {
            $image->blur(10);
        }
        
        // Greyscale
        if ( $request->query( 'grayscale' ) ) {
            $image->greyscale();
        }

        return $image->response();
    }

    public function random( $nickname )
    {
        if ( $nickname === null ) {
            $media = Storage::disk('s3')->url( Location::inRandomOrder()->first()->media );
        } else {
            // Random Image from Specific User
            $user = \App\User::where( 'nickname', $nickname )->first();
            if ( $user === null ) {
                dd("No user found."); // TODO: Throw Exception
            } else {
                $uid = $user->id;
                $media = Storage::disk('s3')->url( Location::where( 'user_id', $uid )->inRandomOrder()->first()->media );
            }
        }

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
    
    public function search( $query, $match, $nickname )
    {
        // From Specific User
        if( $nickname !== null ) {
            $user = \App\User::where( 'nickname', $nickname )->first();
            if ( $user === null ) {
                dd("No user found."); // TODO: Throw Exception
            } else {
                $uid = $user->id;
            }
        }

        if ( $match == "strict" ) {
            // Only based on tags
            $eyeshots = Location::whereRaw("if(FIND_IN_SET(?, tags) > 0, true, false)", [$query]);

            if ( isset( $uid ) ) {
                $eyeshots = $eyeshots->where( 'user_id', $uid );
            }
            $eyeshots = $eyeshots->get();
            
        } else {
            // (Loose (default)) Based on tags and location name
            $eyeshotsByTags = Location::whereRaw("if(FIND_IN_SET(?, tags) > 0, true, false)", [$query])->get();
            $eyeshotsByLocationName = Location::where("location_name", "like", "%$query%")->get();
            $eyeshots = $eyeshotsByTags->merge($eyeshotsByLocationName);
            
            if ( isset( $uid ) ) {
                $eyeshots = $eyeshots->where( 'user_id', $uid );
            }
        }

        $media = Storage::disk('s3')->url( $eyeshots->random()->media );
            
        return Image::make( $media );
    }

    public function imageById( $id )
    {
        $imageId = Helper::decode_id( $id );
        
        $image = Location::where( 'id', $imageId )->first();
        
        $media = Storage::disk('s3')->url( $image->media );
        
        return Image::make( $media );
    }
}
