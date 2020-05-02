<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Location;

class PlaceholderController extends Controller
{
    public function random()
    {
        $media = Storage::disk('s3')->url( Location::inRandomOrder()->first()->media );

        return Image::make($media)->response();
    }
}
