<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class FbPostEyeshot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $eyeshot;
    
    public function __construct( $eyeshot )
    {
        $this->eyeshot = $eyeshot;
    }

    public function handle()
    {
        $eyeshot = $this->eyeshot;
        if ( $eyeshot ) {

    
            // Authenticate via OAuth
            $client = new \Tumblr\API\Client(
                config('services.tumblr.client_id'),
                config('services.tumblr.client_secret'),
                config('services.tumblr.access_token'),
                config('services.tumblr.access_token_secret')
            );
    
            // Make the request
            $client->getUserInfo();
    
            // Post 📰    
            $data = [
                'title' => "test",
                'tags' => "one,two,three",
                'thumbnail' => "https://eyeshot.s3.amazonaws.com/z0nitJSe1XItkWJCJgZc.jpg",
                'url' => "https://eyeshot.xyz?ref=tumblr",
                'type' => 'link'
            ];
    
            $client->createPost("eyeshothq.tumblr.com", $data);
            
            

        }
    }
}
