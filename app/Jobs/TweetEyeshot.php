<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Twitter;
use Helper;

class TweetEyeshot implements ShouldQueue
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

            $post = Helper::createPost( $eyeshot );
            $contents = file_get_contents(Storage::disk('s3')->url($eyeshot->media));
            $uploaded_media = Twitter::uploadMedia(['media' => $contents]);

            // Tweet 🕊
            Twitter::postTweet([
                'status' => $post,
                'media_ids' => $uploaded_media->media_id_string
            ]);
            
        }
    }
}
