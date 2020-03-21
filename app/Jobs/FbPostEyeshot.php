<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Helper;

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

            $post = Helper::createPost( $eyeshot );

            // Post 📰
            $params = [
                'message' => $post,
                'url' => Storage::disk('s3')->url($eyeshot->media),
                'access_token' => config('services.facebook.access_token')
            ];

            $client = new \GuzzleHttp\Client();
            
            $response = $client->request('POST', "https://graph.facebook.com/" . config('services.facebook.page_id') . "/photos", ['query' => $params]);

            $status = $response->getStatusCode();

            if ($status !== 200) {
                throw new \Exception($response->getBody(), $status);
            }

        }
    }
}
