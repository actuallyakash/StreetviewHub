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
}
