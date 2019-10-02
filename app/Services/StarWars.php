<?php
namespace App\Services;
use App\Utils\Helpers;

use GuzzleHttp\Client;
use Exception;

class StarWars {

    public static function getMovieData($link){
        try{
            $guzzle_client = new Client();
        $result = $guzzle_client->request('GET',$link);
        $statusCode = $result->getStatusCode();
        return $result ? json_decode($result->getBody()): false;
        }catch(\Exception $e){

            return Helpers::errorResponse('500', $e->getMessage());
        }
        

       
    }
}