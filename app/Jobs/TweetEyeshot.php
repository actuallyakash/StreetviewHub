<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use App\User;
use Twitter;
use Helper;
use Artisan;

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

            $user = User::find($eyeshot->user_id)->nickname;
            $eyeshotId = Helper::encode_id($eyeshot->id);
            $url = url("/{$user}/shot/{$eyeshotId}");

            if ( $eyeshot->title != null && $eyeshot->title !== "" ) {
                $status = '"' . $eyeshot->title . '"';
            } else if ( $eyeshot->location_name !== NULL && $eyeshot->location_name !== "" ) {
                $status = '"'.$eyeshot->location_name.'"';
            } else {
                $status = "Eyeshot";
            }
            $status .= " by " . $user . "\n\n" . $url;

            $contents = file_get_contents(Storage::disk('s3')->url($eyeshot->media));
            $uploaded_media = Twitter::uploadMedia(['media' => $contents]);

            // Tweet 🕊
            Twitter::postTweet([
                'status' => $status,
                'media_ids' => $uploaded_media->media_id_string
            ]);
        }
    }
}
