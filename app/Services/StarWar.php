<?php
namespace App\Services;
ini_set('max_execution_time', 180); //3 minutes

use Exception;
use GuzzleHttp\Client;

/*
 * @package SocialMedia
 */

class StarWar
{


    public static function printNestedArray($characters) {
        $guzzle_client = new Client();
        $result=[];
               foreach($characters as $character){
                   $data = json_decode($guzzle_client->request("GET", $character)->getBody());
                array_push($result, ['name'=>$data->name, 'height'=>$data->height, 'gender'=>$data->gender]);
               }     
          return $result;
      }


    /**
     * Returns the number of youtube channel subscription and views
     */
    public static function getMovieData()
    {
        $guzzle_client = new Client();
        $result = $guzzle_client->request("GET", "https://swapi.co/api/films");
        if ($result->getStatusCode() !== 200) {
            throw new Exception('Error in connection');
        }
        $movies = json_decode( $result->getBody());
        $data=[];
        foreach($movies->results as $movie){
            array_push($data,[
                'title'=> $movie->title,
                'opening crawl' =>$movie->opening_crawl,
                'characters'=>self::printNestedArray( $movie->characters)
            ]);
        } 
        return $data;
    }



}
