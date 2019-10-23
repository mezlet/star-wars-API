<?php

namespace App\Services;
use App\Helpers;
use GuzzleHttp\Client;
use Exception;
use App\CacheData;


class StarWars {

    /**
     * Get movie data from server
     * @param string $link
     * @return object $result
     */
    public static function getMovieData(string $link){
        $guzzle_client = new Client();
        if($movies_data = CacheData::get($link)){
            return json_decode($movies_data);
        }
        $response = $guzzle_client->request('GET',$link);
        $statusCode = $response->getStatusCode();
        $result = json_decode($response->getBody());
        CacheData::set($link,json_encode($result));
        return $result ? $result: false; 
    }

/**
 * Get movie list
 * @return array $movie_list
 */
public  static function getMovieList(?int $offset=0, ?int $limit=7):array{
    $data = self::getMovieData("https://swapi.co/api/films") ;
    $movie_list = [];

    usort($data->results, function($a, $b){
        return strcmp($a->release_date, $b->release_date);
    });

    $total = count($data->results);
    for($i = 0; $i < $total; $i++ ){
        $movie_id = explode('/',parse_url($data->results[$i]->url)['path'])[3];
        $comment_count = Helpers::getCommentCount($movie_id);
        array_push($movie_list,
        [
            'title' =>$data->results[$i]->title,
            'opening_crawl' =>$data->results[$i]->opening_crawl,
            'release_date' => $data->results[$i]->release_date,
            'url'=>$data->results[$i]->url,
            'movie_id' => $movie_id,
            'comment_count'=>$comment_count
        ]
    );
    } ;

     $paginated_list = array_slice($movie_list, $offset, $limit);

    return $paginated_list;
}


/**
 * Get movie characters
 * @param string $id
 * @param string $sort_param
 * @param string $filter_param
 * @return array $movie_characters
 */
public static  function getMovieCharacters(int $id, ?string $sort_param, ?string $filter_param):array{
    $data = self::getMovieData('https://swapi.co/api/films/'.$id);
    if(isset($data->original)) {
        return false;
    }
    $characters = Helpers::sortData( $data->characters, $sort_param, $filter_param);
        $movie_characters=[
            'characters'=> $characters,
            'realease_date'=> $data->release_date,
            ];
            $movie_characters['total_characters'] = count($movie_characters['characters']);
            $movie_characters['total_height'] = array_reduce($movie_characters['characters'],
            function($total, $item){
                return $total+$item['height'];
            }
        );
        $movie_characters['total_height_in_feet'] = Helpers::getHeight($movie_characters['total_height']);
            return $movie_characters;
    }
}