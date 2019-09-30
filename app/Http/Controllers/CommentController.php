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

    private $request,$ip, $movie_id;

    public function __construct(Request $request ){
        $this->request = $request;
        $this->validate = new Validation();

    }

    public function addComment(){
        $this->validate->validateComment($this->request);
        try{
            if(!Helpers::isMovieExist($this->request->movie_id)){
                return Helpers::errorResponse(404,'Movie not found');
            }
            $comment = Comment::create($this->request->all() + [
                'ip'=>$this->request->ip(),
                ]);

            if($comment){
                   return  Helpers::successResponse(201,$comment,'Comment created successfully.');
                }
                
        }catch(\Exception $e){
            return Helpers::errorResponse(500,$e->getMessage());
        }
    }

    public function getComment($id){
        $this->movie_id =$id;
        try{

            $comment = Comment::where('movie_id',$this->movie_id)->orderBy('created_at', 'desc')->get();
            if($comment){
                return  Helpers::successResponse(200,$comment,'');
             }
        }catch(\Exception $e){
            return Helpers::errorResponse(500,$e->getMessage()); 
        }
    }

}