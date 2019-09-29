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

    private $request,$ip, $title;

    public function __construct(Request $request ){
        $this->request = $request;
        $this->validate = new Validation();

    }


    public function addComment($title){
        $this->title = ucwords(urldecode($title));
        $this->validate->validateComment($this->request);
        try{

            if(!Helpers::isMovieExist($this->title)){
                return Helpers::errorResponse(404,'Movie not found');
            }
            $comment = Comment::create($this->request->all() + [
                'ip'=>$this->request->ip(),
                'title'=>$this->title
                ]);

            if($comment){
                   return  Helpers::successResponse(201,$comment,'Comment created successfully.');
                }
                
        }catch(\Exception $e){
            return Helpers::errorResponse(500,'Something went wrong.');
        }
    }

}