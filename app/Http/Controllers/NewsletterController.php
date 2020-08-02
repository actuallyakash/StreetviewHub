<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function add( Request $request )
    {
        $details = collect([
            'email' => $request->email,
            'source' => $request->source,
        ]);

        Mail::to( config( 'mail.to.address' ) )->send( new NewsletterSubscriber( $details ) );

        return true;
    }
}
