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

        # Already discovered?
        $discovered = Location::where('pano_id', $panoId)->first();

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
            $eyeshotName = Str::random(20) . '.jpg';
            $contents = file_get_contents($filepath);
            // Saving the location image
            Storage::disk('public')->put($eyeshotName, $contents);
            
            $attributes = [
                'user_id' => auth()->id(),
                'location_name' => $locationName,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'pano_id' => $panoId,
                'pano_heading' => $panoHeading,
                'pano_pitch' => $panoPitch,
                'pano_zoom' => $panoZoom,
                'media' => $eyeshotName,
            ];

            // For pioneers
            if ( ! $discovered ) {
                $attributes['pioneer'] = auth()->id();
            }

            Location::create($attributes);
        }

        return 1;
    }

    public function deleteFavourite($panoId)
    {
        $eyeshot = Location::where('pano_id', $panoId)->where('user_id', auth()->id())->first();

        Location::where('pano_id', $panoId)
            ->where('user_id', auth()->id())
            ->delete();

        if ($eyeshot->media) {
            Storage::disk('public')->delete($eyeshot->media);
        }

        return 1;
    }

    public function favouriteDetails(Request $request)
    {
        $response = array(
            'panoId' => $request->panoId,
            'status' => $request->status,
            'tags' => Helper::tagSerialize($request->tags),
        );

        if ($response['tags'] == null) {
            $response['tags'] = 'eyeshot';
        }

        $tags = explode(',', $response['tags']);
        foreach($tags as $tag)
        {
            if( DB::table('tags')->where('tags', '=', $tag)->first() ) {
                DB::table('tags')->where('tags', '=', $tag)->increment('total', 1);
            } else {
                $details = [
                    'tags' => $tag,
                    'total' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                DB::table('tags')->insert($details);
            }
        }
        
        Location::where('pano_id', $response['panoId'])
            ->where('user_id', auth()->id())
            ->update(['status' => $response['status'], 'tags' => $response['tags']]);
        
        return 1;
    }

    public function pioneer($panoId)
    {
        $isPioneer = Location::where('pano_id', $panoId)->whereNotNull('pioneer')->first();
        
        if ( $isPioneer ) {
            $pioneer = User::find($isPioneer->pioneer);

            return $pioneer ? $pioneer : 0;
        } else {
            return 0;
        }
    }
}
