<?php
namespace App\Http\Middleware;

use App\Utils\Helpers;
use Closure;

class ValidateOffsetLimit
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
        if ((isset($request->limit)&& !is_numeric($request->limit)) ||
        ( isset($request->offset) && !is_numeric($request->offset))) {
            return Helpers::errorresponse(400,"Invalid limit/offset parameter supplied.");
        }
        return $next($request);
    }
}
