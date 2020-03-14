<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\User;
use Twitter;
use Illuminate\Support\Facades\Storage;

class TweetEyeshot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $eyeshot;
    
    public function __construct( $eyeshot )
    {
        $this->eyeshot = $eyeshot;
    }
    
    public function handle()
    {
        $eyeshot = $this->eyeshot;

        if ( $eyeshot ) {

            $user = User::find($eyeshot->user_id)->nickname;
            $status = $eyeshot->title == null || $eyeshot->title == "" ? "Eyeshot by @$user" : $eyeshot->location_name ;
            $contents = file_get_contents(Storage::disk('s3')->url($eyeshot->media));
            $uploaded_media = Twitter::uploadMedia(['media' => $contents]);

            // Tweet
            Twitter::postTweet(['status' => $status, 'media_ids' => $uploaded_media->media_id_string]);
        }
    }
}
