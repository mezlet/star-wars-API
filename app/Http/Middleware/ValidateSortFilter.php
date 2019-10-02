<?php
namespace App\Http\Middleware;

use App\Utils\Helpers;
use Closure;

class ValidateSortFilter
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
        $filter_param=['','n/a','female','male'];
        if ((isset($request->sort_param)&& !in_array($request->sort_param,$sort_param,false)) ||
        ( isset($request->filter_param) && !in_array($request->filter_param,$filter_param,false))) {
            return Helpers::errorresponse(400,"Invalid sort/filter parameter supplied.");
        }
        return $next($request);
    }
}
