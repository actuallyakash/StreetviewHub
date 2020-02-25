<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['feed']]);
    }

    public function welcome()
    {
        $eyeshots = Location::latest('created_at')->paginate(6);
        
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

        // Popular doen't need pagination, for now
        $noPaginate = true;
        
        return view('layouts/feed', compact('eyeshots', 'noPaginate'));
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
}
