<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'user_id', 'location_name', 'latitude', 'longitude', 'pano_id', 'pano_heading', 'pano_pitch', 'pano_zoom'
    ];

    public function scopeCheckUserFavouriteExist($query, $panoId)
    {
        return $query->where('pano_id', $panoId)
                    ->where('user_id', auth()->id());
    }
}
