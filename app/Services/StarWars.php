<?php

namespace App\Services;
use App\Utils\Helpers;
use Cache;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Facades\Redis;


class StarWars {

    /**
     * Get movie data from server
     * @param string $link
     * @return object $result
     */
    public static function getMovieData(string $link){
        $guzzle_client = new Client();
        $redis = Redis::connection();
        if($movies_data = $redis->get($link)){
            return json_decode($movies_data);
        }
        $response = $guzzle_client->request('GET',$link);
        $statusCode = $response->getStatusCode();
        $result = json_decode($response->getBody());
        $redis->setex($link,60*60,json_encode($result));
        return $result ? $result: false; 
    }
}