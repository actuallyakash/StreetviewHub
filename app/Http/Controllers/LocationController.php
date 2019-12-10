<?php

namespace App\Http\Controllers;

use Auth;
use App\Location;
use App\User;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    public function hasLikedLocation($panoId)
    {
        $liked = DB::table('locations')
                    ->where('user_id', Auth::user()->id)
                    ->where('pano_id', '=', $panoId)
                    ->first();

        return $liked ? 1 : 0;
    }

    public function storeFavourite($locationName, $latitude, $longitude, $panoId, $panoHeading, $panoPitch, $panoZoom)
    {
        $favourite = Location::checkUserFavouriteExist($panoId);
        # algo for calculating zoom level (based on POV) (https://developers.google.com/maps/documentation/streetview/intro#optional-parameters)
        if ( $panoZoom < 1 ) {
            $zoomLevel = 90;
        } elseif ($panoZoom > 2) {
            $zoomLevel = 20;
        } else {
            $zoomLevel = 120/$panoZoom;
        }

        if ($favourite->count() == 0) {

            // Downloading Image
            $filepath = 'https://maps.googleapis.com/maps/api/streetview?size=400x300&pano='. $panoId .'&fov='. $zoomLevel .'&heading='. $panoHeading .'&pitch='. $panoPitch .'&key=AIzaSyBD52XR31rIk-MaE6AKlj_pLYlKxeJGUBQ';

            // Saving the location image
            $eyeshotName = Str::random(20) . '.jpg';
            $contents = file_get_contents($filepath);
            Storage::disk('public')->put($eyeshotName, $contents);
            
            Location::create([
                'user_id' => auth()->id(),
                'location_name' => $locationName,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'pano_id' => $panoId,
                'pano_heading' => $panoHeading,
                'pano_pitch' => $panoPitch,
                'pano_zoom' => $panoZoom,
                'media' => $eyeshotName,
            ]);
        }
        return 1;
    }

    public function deleteFavourite($panoId)
    {
        Location::where('pano_id', $panoId)
            ->where('user_id', auth()->id())
            ->delete();

        return 1;
    }

    public function favouriteDetails(Request $request)
    {
        $response = array(
            'panoId' => $request->panoId,
            'status' => $request->status,
            'tags' => Helper::tagSerialize($request->tags),
        );
        
        Location::where('pano_id', $response['panoId'])
            ->where('user_id', auth()->id())
            ->update(['status' => $response['status'], 'tags' => $response['tags']]);
        
        return 1;
    }
}
