<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Comment;
use App\Services\StarWars;
use Illuminate\Http\Request;
use App\Utils\Helpers;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Laravel\Lumen\Routing\Controller as BaseController;

class MovieController extends Basecontroller{
    public $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    /**
     * Get movie list
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMovieList()
    {
        try{
            $movies = Helpers::getMovieList($this->request->offset, $this->request->limit);
            return Helpers::successResponse(200,$movies,'');
        }catch(\Exception $e){
            return Helpers::errorResponse(500,'Something went wrong');
        }
    }

    /**
     * Get movie characters
     * @param string $movie_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMovie($movie_id){
        
        try{
            $movies = Helpers::getMovieCharacters($movie_id,$this->request->sort_param,$this->request->filter_param);
            if($movies){
                return Helpers::successResponse(200,$movies,'');
            }
            return Helpers::errorResponse(404,'Movie not found');
        }catch(\Exception $e){
            return $e;
            return Helpers::errorResponse(500,'Something went wrong');
        }
    }


}