<?php

namespace App\Http\Controllers;

use Auth;
use App\Location;
use App\User;
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

    public function storeFavourite($locationName, $latitude, $longitude, $panoId, $panoHeading, $panoPitch)
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
}
