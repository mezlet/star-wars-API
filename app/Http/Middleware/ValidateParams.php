<?php
namespace App\Http\Middleware;

use App\Utils\Helpers;
use Closure;

class ValidateParams
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
        if (!is_numeric($request->movie_id) || empty($request->movie_id)) {
            return response()->json(['success'=>false, 'error'=>"Invalid parameter supplied."],400);
        }
        return $next($request);
    }
}
