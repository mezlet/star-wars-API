<?php
namespace App\Services;
use App\Utils\Helpers;

use GuzzleHttp\Client;
use Exception;

class StarWars {

    public static function getMovie($link){
        try{
            $guzzle_client = new Client();
        $result = $guzzle_client->request('GET',$link);
        return $result ? json_decode($result->getBody()) : false;

        }catch(\Exception $e){

            return Helpers::errorResponse('500', $e->getMessage());
        }
        

       
    }
}