<?php

namespace App\Http\Controllers;

use Auth;
use App\Location;
use App\User;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        if ($favourite->count() == 0) {
            Location::create([
                'user_id' => auth()->id(),
                'location_name' => $locationName,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'pano_id' => $panoId,
                'pano_heading' => $panoHeading,
                'pano_pitch' => $panoPitch,
                'pano_zoom' => $panoZoom,
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
