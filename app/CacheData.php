<?php
namespace App;
use Cache;
use Carbon\Carbon;

class CacheData {

    public static function set($link, $result){
        $date = new Carbon();
       return  Cache::put($link, $result,$date::now()->addHours(1)->toDateTimeString());
    }

    public static function get($link){
        return  Cache::get($link);
     }

}