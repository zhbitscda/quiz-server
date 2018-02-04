<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Log;

class LoggerMiddleware {

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ip     = $request->ip();
        $path   = $request->path();
        $method = $request->method();
        $input  = json_encode($request->all());
        $data   = file_get_contents("php://input");
        $header = $request->header();
        // $content_type = $header['content-type'][0];
        // $accept_language = $header['accept-language'][0];
        //
        // $str = "[FUNC=$path]" . "[METHOD=$method]" .
        //        "[IP=$ip]" . "[CONTENT_TYPE=$content_type]" .
        //       "[LANG=$accept_language]" . "[DATA=$input]";

        $str = "[FUNC=$path]" . "[METHOD=$method]" .
               "[IP=$ip]" . "[DATA=$input] .[ORIDATA=$data]";

        Log::info($str);

        return $next($request);
    }

}
