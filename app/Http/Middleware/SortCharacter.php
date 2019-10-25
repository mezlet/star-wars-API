<?php
namespace App\Http\Middleware;

use App\Utils\Helpers;
use Closure;

class SortCharacter
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
        $sort_param = ['','name','gender','height'];
        if ((isset($request->sort_param)&& !in_array($request->sort_param,$sort_param,false))) {
            return response()->json(['success'=>false, 'error'=>"Invalid sort parameter supplied."],400);
        }
        return $next($request);
    }
}
