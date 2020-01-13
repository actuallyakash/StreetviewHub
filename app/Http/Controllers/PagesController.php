<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['feed']]);
    }

    public function feed()
    {
        $eyeshots = Location::latest('created_at')->paginate(9);
        
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
}
