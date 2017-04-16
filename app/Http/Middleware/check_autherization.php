<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use InfyOm\Generator\Utils\ResponseUtil;
use Illuminate\Support\Facades\Request;

class check_autherization
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
        if (Request::header('Authorization')) {
            return $next($request);
        }else {
              return Response::json([ResponseUtil::makeError('You don\'t have permission to access this URL ')], 404);
          }
    }


}
