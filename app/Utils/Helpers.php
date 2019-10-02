<?php

namespace App\Utils;
use GuzzleHttp\Client;
use App\Services\StarWars;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class Helpers{

    private static $sort_param,$filter_param;

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
    public static function getMovieList($offset = 0, $limit = 7) {
        $data = starwars::getMovieData("https://swapi.co/api/films");
        $movie_list = [];
        usort($data->results, function($a, $b)
        {
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
        } 
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
        public static function getMovieCharacters($id, $sort_param='', $filter_param=''){
            $movie_characters = [];
            $data = StarWars::getMovieData('https://swapi.co/api/films/'.$id);

            if(isset($data->original)) {
                return false;
            }

                array_push($movie_characters,[
                    'comment_count' => self::getCommentCount($id),
                    'title' => $data->title,
                    'opening_crawl' => $data->opening_crawl,
                    'characters'=> self::sortData( $data->characters, $sort_param, $filter_param),
                    'realease_date'=> $data->release_date,
                    ]);
                    $movie_characters[0]['total_characters'] = count($movie_characters[0]['characters']);
                    return $movie_characters;
            }

    /**
     * Get heights in feet and inches
     * @param string $height
     * @return string $converted_height
     */
    public static function getHeight($height){
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
        public static function filterCharacters($sorted_array, $filter_param){
            $filtered_array =[];
            if(!$filter_param || empty($filter_param)){
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

    public static function sortData($characters, $sort_param, $filter_param){
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

        if(!$sort_param || empty($sort_param)){
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
    public static function getComments($movie_id, $offset=0, $limit=5){
        $comment = DB::table('comment')->where('movie_id',$movie_id)->orderBy('created_at', 'desc')->paginate(5);
        return $comment;
    }

}