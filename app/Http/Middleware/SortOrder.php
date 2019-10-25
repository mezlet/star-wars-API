<?php
namespace App\Http\Middleware;
use Closure;

class SortOrder {

    public function handle($request,Closure $next){
        $values = ['','descending', 'ascending'];
        if(isset($request->sort_param)){
        $sort_param = strtolower($request->sort_order);
            if(!in_array($sort_param, $values)){
                return response()->json(['success'=>false, 'error'=>'Invalid sort order.'], 400);
            }
        }

       return  $next($request);
    }
}