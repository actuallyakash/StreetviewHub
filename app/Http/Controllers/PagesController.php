<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

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
}
