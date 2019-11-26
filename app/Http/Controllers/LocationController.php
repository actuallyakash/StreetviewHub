<?php

namespace App\Http\Controllers;

use Auth;
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
}
