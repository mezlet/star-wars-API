<?php

namespace App;
use GuzzleHttp\Client;
use App\Services\StarWars;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class Helpers{

private static $sort_param,$filter_param, $offset, $limit, $validate;


/**
 * Get comment count
 * @param string $title
 * @return int $count
 */
public static function getCommentCount(string $id): int{
    $count = Comment::where('movie_id',$id)->count();
    return $count;
}

/**
 * Get movie list
 * @return array $movie_list
 */
public  static function getMovieList(?int $offset=0, ?int $limit=7):array{
    $data = StarWars::getMovieData("https://swapi.co/api/films") ;
    $movie_list = [];

    usort($data->results, function($a, $b){
        return strcmp($a->release_date, $b->release_date);
    });

    foreach($data->results as $movie){
        array_push($movie_list,[
            'title' =>$movie->title,
            'opening_crawl' =>$movie->opening_crawl,
            'release_date' => $movie->release_date,
            'url'=>$movie->url,
            'movie_id' => explode('/',parse_url($movie->url)['path'])[3],
            'comment_count'=>self::getCommentCount(explode('/',parse_url($movie->url)['path'])[3])
        ]);
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
    public static  function getMovieCharacters(int $id, ?string $sort_param, ?string $filter_param): array{
        $data = StarWars::getMovieData('https://swapi.co/api/films/'.$id);

        if(isset($data->original)) {
            return false;
        }

            $movie_characters=[
                'characters'=> self::sortData( $data->characters, $sort_param, $filter_param),
                'realease_date'=> $data->release_date,
                ];
                $movie_characters['total_characters'] = count($movie_characters['characters']);
                $movie_characters['total_height'] = array_reduce($movie_characters['characters'],
                function($total, $item){
                    return $total+$item['height'];
                }
            );
            $movie_characters['total_height_in_feet'] = self::getHeight($movie_characters['total_height']);
                return $movie_characters;
        }

/**
 * Get heights in feet and inches
 * @param string $height
 * @return string $converted_height
 */
public static function getHeight(string $height): string{
    $number= $height *  0.0328;
    $feet= floor($number);
    $fraction = $number -$feet;
    $inch = round($fraction * 12);
    $converted_height ="$feet'$inch";
    return $converted_height;
}



    /**
     * Filter movie character
     * @param array $sorted_array
     * @param string $filter_param
     * @return array $filtered_array
     */
    public static function filterCharacters(array $sorted_array, ?string $filter_param): array{
        $filtered_array =[];
        if(!$filter_param || empty($filter_param || $filter_param=null)){
            return $sorted_array;
        }

        foreach($sorted_array as $character) {
        if(strcasecmp($character['gender'], $filter_param) == 0)
        $filtered_array[] = $character;
    }
    return $filtered_array;
    }


    /**
     * Sort movie characters
     * @param array $character
     * @param string $sort_param
     * @param $filter_param
     * @return array $filtered_array
     */

    public static function sortData(array $characters, ?string $sort_param, ?string $filter_param): array
    {
            $movie_characters = [];
            $sum_height=0;

            foreach($characters as $character){
                $response = StarWars::getMovieData($character);
                array_push($movie_characters,array(
                'name'=> $response->name, 
                'gender'=>$response->gender, 
                'height'=>$response->height,
                'height_in_feet'=>self::getHeight($response->height)));
            }

            if(!$sort_param || empty($sort_param || $sort_param=null)){
                return $movie_characters;
            }
            
            usort($movie_characters, function($a, $b) use($sort_param)
            {return strcmp($a[$sort_param], $b[$sort_param]);});

            $filtered_array = self::filterCharacters($movie_characters,$filter_param);  

            return $filtered_array;
    }

/**
 * Get user comments
 * @param int $movie_id
 * @param int $offset
 * @param int $limit
 * @return object $comment
 */
public static function getComments(int $movie_id, ?int $offset=0, ?int $limit=5):object{
    $comment =Comment::where('movie_id',$movie_id)
    ->orderBy('created_at', 'desc')->skip($offset)->take($limit)->get();
    return $comment;
}

}