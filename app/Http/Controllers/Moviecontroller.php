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

    public function getMovie($title){
        try{
            $movies = Helpers::getMovie(ucwords(urldecode($title)));
            return Helpers::successResponse(200,$movies,'');
        }catch(\Exception $e){
            return Helpers::errorResponse(500,'Something went wrong.');
        }
    }

    public static function getMovieList()
    {
        try{
            $movies = Helpers::getMovieList();
            return Helpers::successResponse(200,$movies,'');
        }catch(\Exception $e){
            return Helpers::errorResponse(500,'Something went wrong.');
        }
    }


}