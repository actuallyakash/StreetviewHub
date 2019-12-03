<?php

use Illuminate\Support\Facades\DB;

class Helper
{
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
    
}
