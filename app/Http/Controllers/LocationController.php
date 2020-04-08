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
use Carbon\Carbon;

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
            $filepath = 'https://maps.googleapis.com/maps/api/streetview?size=400x300&pano=' . $panoId . '&fov=' . $zoomLevel . '&heading=' . $panoHeading . '&pitch=' . $panoPitch . '&key=' . config('services.gmaps_key');
            $eyeshotName = Str::random(20) . '.jpg';
            $contents = file_get_contents($filepath);
            // Saving the location image
            Storage::disk('s3')->put($eyeshotName, $contents);
            
            $attributes = [
                'user_id' => auth()->id(),
                'location_name' => $locationName == "null" ? NULL : $locationName,
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
            Storage::disk('s3')->delete($eyeshot->media);
        }

        return 1;
    }

    public function favouriteDetails(Request $request)
    {
        $response = array(
            'panoId' => $request->panoId,
            'title' => $request->title,
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

        $location = Location::where('pano_id', $response['panoId'])->where('user_id', auth()->id());
        $location->update(['title' => $response['title'], 'status' => $response['status'], 'tags' => $response['tags']]);

        // Queueing Jobs
        \App\Jobs\TweetEyeshot::dispatch( $location->first() )->delay( now()->addMinutes(10) ); // Tweet
        \App\Jobs\FbPostEyeshot::dispatch( $location->first() )->delay( now()->addMinutes(10) ); // Publish
        \App\Jobs\TumblrPostEyeshot::dispatch( $location->first() ); // Publish
        
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

    // Returns eyeshot details for modal
    public function eyeshot( $eyeshotId )
    {
        $eyeshot = Location::find(Helper::decode_id($eyeshotId))->toArray();
        $user = User::find($eyeshot['user_id']);
        $totalEyeshots = Location::where('pano_id', $eyeshot['pano_id'])->count();
        
        $eyeshot['created_at'] = Carbon::parse($eyeshot['created_at'])->diffForHumans();
        $eyeshot['eyeshot_saves'] = $totalEyeshots;
        $eyeshot['user_avatar'] = $user->avatar;
        $eyeshot['eyeshot_by'] = $user->name;
        $eyeshot['user_nickname'] = $user->nickname;

        if ( $eyeshot ) {
            return $eyeshot;
        } else {
            return 0;
        }
    }
}
