<?php
namespace App\Http\Middleware;

use App\Services\StarWars;
use Closure;
use GuzzleHttp\Exception\RequestException;

class CheckMovie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $id = $request->movie_id;
            $data = StarWars::getMovieData('https://swapi.co/api/films/'.$id);
        }catch( RequestException $e ) {
            if ($e->hasResponse()) {
            return response()->json([
            'success'=>false,
             'error'=>"Movie not found"
            ],404);
    }
            
        }
        return $next($request);
    }
}
