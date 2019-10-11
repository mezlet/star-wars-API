<?php

namespace App\Http\Controllers;

use Exception;
use Cache;
use App\Models\Comment;
use App\Services\StarWars;
use Illuminate\Http\Request;
use App\Helpers;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;

use Laravel\Lumen\Routing\Controller as BaseController;

class MovieController extends Basecontroller{

    private $redis;
    public function __construct(){
        // $this->redis = Redis::connection();
    }

    /**
     * Get movie list
     * @param object request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMovieList(Request $request)
    {
        try{       
            $movies = Helpers::getMovieList($request->offset, $request->limit);
            return response()->json(["success"=>true, "data"=>$movies],200);

        }catch(TypeError $e){
            return response()->json(["success"=>false, "error"=>$e->getMessage()]);
        }
        catch(\Exception $e){
        return response()->json(["success"=>false, "error"=>'Something went wrong.'],500);
        }
    }

    /**
     * Get movie characters by their movie id
     * @param string $movie_id
     * @param object $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMovie(Request $request, int $movie_id): \Illuminate\Http\JsonResponse{
        try{
            $characters = Helpers::getMovieCharacters($movie_id,$request->sort_param,$request->filter_param);
            return response()->json(["success"=>true, "data"=>$characters],200);

        }catch(TypeError $e){
            return response()->json(["success"=>false, "error"=>$e->getMessage()]);
        }
        catch(\Exception $e){

            return response()->json(["success"=>false, "error"=>'Something went wrong.'],500);
        }
    }


}