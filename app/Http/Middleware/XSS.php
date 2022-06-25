<?php

namespace App\Http\Middleware;

use Closure;

class XSS
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
        $input = $request->all();

        array_walk_recursive($input, function(&$input) {

            $input = $this->xss_cleaner($input);

        });

        $request->merge($input);
        return $next($request);
    }

    function xss_cleaner($string){

        $codes = array("script","java","applet","iframe","meta","object","html","CONCAT","CHAR","FLOOR","RAND", "<", ">", ";", "'","%");
        $string = str_replace($codes,"",$string);
        $string = strip_tags($string);
        $string = htmlspecialchars($string, ENT_QUOTES,"UTF-8");
        return $string;
    }
}
