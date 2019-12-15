<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index($nickname)
    {
        $user = User::where('nickname', $nickname)->firstOrFail();        
        
        return view('layouts/profile', compact('user'));
    }
}
