<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\StarWars;
use Illuminate\Http\Request;
use App\Helpers;

use Laravel\Lumen\Routing\Controller as BaseController;

class MovieController extends Basecontroller{
    private $sort_param;

    /**
     * Get movie list
     * @param object request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMovieList(Request $request):\Illuminate\Http\JsonResponse
    {
            try{       
            $movies = StarWars::getMovieList($request->offset, $request->limit);
            return response()->json(["success"=>true, "data"=>$movies],200);
        }
        catch(\Exception $e){

        return response()->json(["success"=>false, "error"=>'Somethin?g went wrong.'],500);
        }
    }

    /**
     * Get movie characters by their movie id
     * @param string $movie_id
     * @param object $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMovie(Request $request, int $movie_id): \Illuminate\Http\JsonResponse{
        $this->sort_param = isset($request->sort_param) ? $request->sort_param : 'name';
        try{
            $characters = StarWars::getMovieCharacters($movie_id,$this->sort_param,$request->filter_param, $request->sort_order);
            return response()->json(["success"=>true, "data"=>$characters],200);

        }
        catch(\Exception $e){
            return response()->json(["success"=>false, "error"=>$e->getMessage()],500);

            return response()->json(["success"=>false, "error"=>'Something went wrong.'],500);
        }
    }


}