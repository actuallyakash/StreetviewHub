<?php

namespace App\Jobs;

require_once( base_path() . '/vendor/tumblr/tumblr/lib/Tumblr/API/Client.php' );

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Helper;

class TumblrPostEyeshot implements ShouldQueue
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

            $status = Helper::createPost( $eyeshot, 'tumblr' );
            
            // Post 📰    
            $post = [
                'type' => 'photo',
                'caption' => $status,
                'link' => "https://eyeshot.xyz",
                'tags' => $eyeshot->tags !== null ? $eyeshot->tags : 'eyeshot',
                'source' => Storage::disk('s3')->url($eyeshot->media)
            ];

            $client->createPost("eyeshothq.tumblr.com", $post);
        
        }
    }
}
