<?php
namespace App\Http\Controllers;


use App\Services\StarWar;
use Exception;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * @return object \Illuminate\Http\JsonResponse
     */
    public function getMovies()
    {
        try {
            $data = StarWar::getMovieData();
            return response()->json([$data]);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Something went wrong']);
        }
    }


}
