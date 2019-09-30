<?php

namespace App\Utils;
use GuzzleHttp\Client;
use App\Services\StarWars;
use App\Models\Comment;

class Helpers{

    /**
     * Success response
     * @param int $statusCode
     * @param array $data
     * @param string $message
     * @return object json response
     */
    public static function successResponse($statusCode, $data=[], $message=null)
    {
        return response()->json([
        'success'=>true,
        'data'=> $data, 
        'message'=>$message
        ],$statusCode);
    }


    /**
     * Error Response
     * @param int $statusCode
     * @param string $messsage
     * @return object json response
     */
    public static function errorResponse($statusCode,  $message=null)
    {
        return response()->json([
        'success' =>false,
        'error'=>$message
        ],$statusCode);
    }

    /**
     * Get Movie characters
     * @param array $characters
     * @return array $movie_characters
     */
    public static function getCharacters($characters){
        $guzzle_client = new Client();
        $movie_characters = [];
        foreach($characters as $character){
            $response = json_decode($guzzle_client->request('GET',$character)->getBody());
            array_push($movie_characters,$response->name);
        }
        return $movie_characters;
    }

    /**
     * Get single movie
     * @param string title
     * @return array $movie
     */
    public static function getMovie($id){
        $movie = [];
        $data = StarWars::getMovie('https://swapi.co/api/films/'.$id);
        array_push($movie,[
            'comment_count' => self::getCommentCount($id),
            'title' => $data->title,
            'opening_crawl' => $data->opening_crawl,
            'character'=> self::getCharacters( $data->characters),
            'realease_date'=> $data->release_date
            ]);
        return $movie;
    }

    /**
     * Check if movie exists
     * @param string $title
     * @return boolean true|false
     */
    public static function isMovieExist($id){
        $data = StarWars::getMovie('https://swapi.co/api/films/'.$id);
        return $data;
        return $data ? true : false;
    }


    /**
     * Get comment count
     * @param string $title
     * @return int $count
     */
    public static function getCommentCount($id){
        $count = Comment::where('movie_id',$id)->count();
        return $count;
    }

    /**
     * Get movie list
     * @return array $movie_list
     */
    public static function getMovieList(){
        $data = starwars::getMovie("https://swapi.co/api/films");
        $movie_list = [];
        usort($data->results, function($a, $b)
        {
         return strcmp($a->release_date, $b->release_date);
        });

        foreach($data->results as $movie){
            array_push($movie_list,[
                'opening_crawl' =>$movie->opening_crawl,
                'release_date' => $movie->release_date,
            ]);
        } 
        return $movie_list;
    }


}