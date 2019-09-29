<?php
namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class StarWars {

    public static function getMovie($link){
        $guzzle_client = new Client();
        $result = $guzzle_client->request('GET',$link);
        if ($result->getStatusCode() !== 200) {
            throw new Exception('Error connecting to Swapi');
        }
        $data = json_decode($result->getBody());
        return $data;
    }
}