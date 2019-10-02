<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Utils\Helpers;
use App\Services\StarWars;
use App\Utils\Validation;
use Laravel\Lumen\Routing\Controller as BaseController;

class CommentController extends Basecontroller{

    private $request,$ip;

    public function __construct(Request $request ){
        $this->request = $request;
        $this->validate = new Validation();

    }

    /**
     * Add comment
     * @param string $movie_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addComment($movie_id){
        $this->validate->validateComment($this->request);
        try{
            if(!Helpers::getMovieCharacters($movie_id)){
                return Helpers::errorResponse(404,'Movie not found');
            }
            $comment = Comment::create($this->request->all() + [
                'ip'=>$this->request->ip(),
                'movie_id'=>$movie_id
                ]);

            if($comment){
                   return  Helpers::successResponse(201,$comment,'Comment created successfully.');
                }
                
        }catch(\Exception $e){
            return Helpers::errorResponse(500,'Something went wrong');
        }
    }

    /**
     * Get commment
     * @param string $movie_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComments($movie_id){
        try{
            $comment = Helpers::getComments($movie_id);
            if($comment->total()!= 0){
                return  Helpers::successResponse(200,$comment,'');
             }
             return Helpers::errorResponse(404,'No comment found'); 
        }catch(\Exception $e){
            return Helpers::errorResponse(500,'Something went wrong'); 
        }
    }

}