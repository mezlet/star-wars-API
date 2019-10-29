<?php
namespace App\Http\Middleware;

use App\Utils\Helpers;
use Closure;

class FilterCharacter
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
        $filter_param=['','n/a','female','male','none','hermaphrodite','unknown'];
        if (( isset($request->filter_param) && !in_array($request->filter_param,$filter_param,false))) {
            return response()->json(['success'=>false, 'error'=>"Invalid filter parameter supplied."],400);
        }
        return $next($request);
    }
}
