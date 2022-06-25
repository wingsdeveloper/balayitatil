<?php

namespace App\Http\Middleware;

use App\Repo\ErrorLogging\Telegram;
use Closure;

class BanIpAddress
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
        return $next($request);
        $ip_arr = ["84.17.46.156", "84.17.46.228", "104.249.46.49", "149.154.161.5", "104.249.46.48", "149.154.161.12",
            '159.69.188.187', '104.249.46.43', '149.154.161.11', '159.69.188.187',
//            '31.13.103.9',
//            '31.13.103.10',
//            '31.13.103.11',
//            '31.13.103.12',
//            '31.13.103.13',
//            '31.13.103.14',
//            '31.13.103.15',
//            '31.13.103.16',
//            '31.13.103.17',
//            '31.13.103.18',
//            '31.13.103.19',

        ];
        if(in_array($request->ip(), $ip_arr)):
            $telegram = new Telegram('998877864:AAERNdWpQRoJ5j6dNkS3m6ww3Oj2RY1IZrg', false);
            $telegram->endpoint('sendMessage', ['chat_id' => -1001201590218, 'text' => "ZARARLI ISTEK " .  $request->url() . ' ' . $_SERVER['HTTP_REFERER'] . ' ' . $_SERVER['HTTP_USER_AGENT'] . ' ' . $request->ip()] );
            return 'Will be back';
            exit();
        endif;
        return $next($request);
    }
}
