<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Helper;
use App\User;
use App\Location;

class PagesController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['feed']]);
    }

    public function welcome()
    {
        $ids = Location::latest('created_at')->take(18)->pluck('id');
        $eyeshots = Location::wherein('id', $ids)->paginate(6);
        
        return view('welcome', compact('eyeshots'));
    }

    public function feed()
    {
        $eyeshots = Location::latest('created_at')->paginate(9);
        
        return view('layouts/feed', compact('eyeshots'));
    }

    public function popular()
    {
        // Reference: https://stackoverflow.com/questions/12235595/find-most-frequent-value-in-sql-column#answer-12235631
        $popularEyeshots = DB::table('locations')
            ->selectRaw('pano_id, count(pano_id) as pano_saves')
            ->groupBy('pano_id')
            ->orderByRaw('`pano_saves` DESC')
            ->get();
        
        $eyeshots = $popularEyeshots->map(function ($pano) {
            if( $pano->pano_saves > 1 ) {
                return Location::where('pano_id', $pano->pano_id)->get();
            }
        })->flatten();

        // Removing Null values
        $eyeshots = $eyeshots->filter(function( $eyeshot ) {
            if ( $eyeshot !== null )
                return $eyeshot;
        });
        
        return view('layouts/feed', compact('eyeshots'));
    }

    public function search()
    {
        $searchTerm = $_GET['q'];

        $eyeshotsByTags = Location::whereRaw("if(FIND_IN_SET(?, tags) > 0, true, false)", [$searchTerm])->get();
        $eyeshotsByLocationName = Location::where("location_name", "like", "%$searchTerm%")->get();

        $eyeshots = $eyeshotsByTags->merge($eyeshotsByLocationName);

        return view('search', compact('eyeshots'));
    }

    public function categories()
    {
        $categories = DB::table('tags')->orderBy('tags', 'asc')->get();
        
        foreach( $categories as $cat ) {
            if( !preg_match("/^[a-z]$/i", $cat->tags[0])) {
                $filteredCats['other'][] = ['title' => $cat->tags, 'total' => $cat->total];
            } else {
                $filteredCats[strtolower($cat->tags[0])][] = ['title' => strtolower($cat->tags), 'total' => $cat->total];
            }
        }

        return view('categories', compact('filteredCats'));
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function show($username, $eyeshotId)
    {
        $eyeshot = Location::findOrFail(Helper::decode_id($eyeshotId));

        $user = User::where('id', $eyeshot->user_id)
                    ->where('nickname', $username)
                    ->first();

        return view('user-eyeshot', compact('user', 'eyeshot'));
    }

    public function sharer( Request $request )
    {
        $eyeshot = $request->pano;

        $sharer = DB::table( 'sharer' )->insertGetId([
            'eyeshot' => $eyeshot,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);
        
        $sharerId = Hashids::encode( $sharer );

        DB::table( 'sharer' )->where( 'id', $sharer )->update([ 'share_id' => $sharerId ]);

        return $sharerId;
    }

    public function getSharer( $sharer )
    {
        $eyeshot = DB::table( 'sharer' )->where( 'share_id', $sharer )->value( 'eyeshot' );
        
        return $eyeshot;
    }

    public static function placeholder()
    {
        $totalCalls = number_format( DB::table( 'plogs' )->get()->count() );
        $todayCalls = number_format( DB::table( 'plogs' )->whereDay('created_at', now()->day)->get()->count() );

        return view('placeholder', compact('totalCalls', 'todayCalls'));
    }
}
