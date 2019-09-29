<?php
namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class StarWars {

    public static function getMovie($title){
        $guzzle_client = new Client();
        $movie = [];
        $result = $guzzle_client->request('GET','https://swapi.co/api/films/?search='.$title);
        if ($result->getStatusCode() !== 200) {
            throw new Exception('Error connecting to Swapi');
        }
        $data = json_decode($result->getBody());
        return $data;
    }
}