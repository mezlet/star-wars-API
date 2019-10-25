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
        array_push($filtered_array,$character);
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

    public static function sortData(array $characters, ?string $sort_param,?string $filter_param, ?string $sort_order) :array
    {
        $movie_characters = [];
        $sum_height=0;
        $total = count($characters);
        for($i = 0; $i< $total; $i++){
            $response = StarWars::getMovieData($characters[$i]);
            array_push($movie_characters,array(
                'name'=> $response->name, 
                'gender'=>$response->gender, 
                'height'=>$response->height,
                'height_in_feet'=>self::getHeight($response->height)));
            }
            usort($movie_characters, function($a, $b) use($sort_param,$sort_order)
            {
                return (isset($sort_order) && $sort_order==='descending') ?
                 strnatcmp($b[$sort_param],$a[$sort_param]):
                 strnatcmp($a[$sort_param],$b[$sort_param]) ;
            });

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