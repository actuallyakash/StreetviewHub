<?php

namespace App\Http;

use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;

class Helper
{
    public static function encode_id($id)
    {
        $hashId = Hashids::encode($id);
        
        return $hashId;
    }

    public static function decode_id($hashId)
    {
        $rehash = Hashids::decode($hashId);
        
        if ( empty( $rehash ) ) {
            return null;
        } else {
            return $rehash[0];
        }
    }

    public static function tagSerialize($tagsString = null)
    {
        if (isset($tagsString) && $tagsString != '') {
            $tags = '';
            foreach (json_decode($tagsString) as $allTags) {
                $tags .= $allTags->value . ',';
            }
            return substr($tags, 0, -1);
        } else {
            return '';
        }
    }
    
    public static function trendingTags() 
    {
        $tags = DB::table('tags')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        return $tags;
    }

    public static function createPost( $eyeshot, $platform = "default" )
    {
        $user = \App\User::find($eyeshot->user_id)->nickname;
        $eyeshotId = Helper::encode_id($eyeshot->id);

        if ( $platform == "tumblr" ) {
            $url = "<b><a href='" . url("/{$user}/shot/{$eyeshotId}") . "'>See 360° View</a></b>";

            if ( $eyeshot->title != null && $eyeshot->title !== "" ) {
                $status = "<b>$eyeshot->title</b>";
            } else if ( $eyeshot->location_name !== NULL && $eyeshot->location_name !== "" ) {
                $status = "<b>$eyeshot->location_name</b>";
            } else {
                $status = "Eyeshot";
            }
            $status .= "<br><br>" . $url;

            if ( $eyeshot->status ) {
                $status .= "<br><br><i>$eyeshot->status</i>";
            }
        } else {
            $url = "See 360° View: " . url("/{$user}/shot/{$eyeshotId}");

            if ( $eyeshot->title != null && $eyeshot->title !== "" ) {
                $status = $eyeshot->title;
            } else if ( $eyeshot->location_name !== NULL && $eyeshot->location_name !== "" ) {
                $status = $eyeshot->location_name;
            } else {
                $status = "Eyeshot";
            }
            $status .= "\n\n" . $url;
        }

        return $status;
    }

    public static function plog( $request, $response )
    {
        DB::table('plogs')->insert([
            'url' => $request->fullUrl(),
            'client_ip' => $request->ip(),
            'response_code' => $response['code'],
            'response_status' => $response['status'],
            'response_message' => $response['message'],
            'created_at' => NOW(),
            'updated_at' => NOW()
        ]);
    }

    // Get related posts based on tags in a single post
    public static function getRelatedPosts( $eyeshotId, $tags, $postCount )
    {
        $eyeshots = [];

        // Fetch related eyeshots excluding the [$eyeshotId]
        foreach ( $tags as $tag ) {
            $eyeshots[] = \App\Location::where([
                                [ "tags", "like", "%$tag%" ],
                                [ "id", '<>', $eyeshotId ]
                            ])->get();
        }

        // Removing null & duplicate values and collapsing the array
        $relatedPosts = collect($eyeshots)->collapse()->unique();
        
        return $relatedPosts->take( $postCount );
    }
}
