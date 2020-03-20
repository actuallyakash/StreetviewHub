<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\User;
use Helper;

class FbPostEyeshot implements ShouldQueue
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

        $client = new \GuzzleHttp\Client();

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

            // Post 📰
            $params = [
                'message' => $status,
                'url' => Storage::disk('s3')->url($eyeshot->media),
                'access_token' => config('services.facebook.access_token')
            ];

            $response = $client->request('POST', "https://graph.facebook.com/" . config('services.facebook.page_id') . "/photos", ['query' => $params]);

            $status = $response->getStatusCode();

            if ($status !== 200) {
                throw new \Exception($response->getBody(), $status);
            }

        }
    }
}
