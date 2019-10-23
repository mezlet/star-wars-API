<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Helpers;
use App\Services\StarWars;
use App\Utils\Validation;
use Laravel\Lumen\Routing\Controller as BaseController;

class CommentController extends Basecontroller{

    private $ip;

    /**
     * Add comment
     * @param int $movie_id
     * @param object $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addComment(Request $request, int $movie_id){
        $this->validate($request, ['comment' => 'required|string|max:500']); 
            try{
            $comment = Comment::create($request->all() + [
                'ip'=>$request->ip(),
                'movie_id'=>$movie_id
                ]);

            if($comment){
                 return response()->json([
                 "success"=>true, "data"=>$comment,"message"=>'Comment created successfully.'],201);
                }
                
        }
        catch(\Exception $e){
            return response()->json(["success"=>false, "error"=>'Something went wrong'],500);
        }
    }

    /**
     * Get commment
     * @param int $movie_id
     * @param object $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComments(Request $request, int $movie_id){

        try{

            $comment = Helpers::getComments($movie_id, $request->offset, $request->limit );
            return response()->json(["success"=>true, "data"=>$comment],200);
            
            }
        catch(\Exception $e){
            return response()->json(["success"=>false, "error"=>'Something went wrong'],500);
        }
    }

}