<?php

namespace App\Exceptions;

use App\Repo\ErrorLogging\Telegram;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Events\AdminHataMailBildir;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        /* try {

         event(new AdminHataMailBildir($exception->getTrace()));
         } catch (\Exception $e) {

         }*/
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {


        try {
            $exploded = explode('.', $request->url());
            if (is_array($exploded)):
                if (!in_array(end($exploded), 'css', 'js', 'jpeg', 'jpg', 'map')):
                    $telegram = new Telegram('998877864:AAERNdWpQRoJ5j6dNkS3m6ww3Oj2RY1IZrg', false);
                    $telegram->endpoint('sendMessage', ['chat_id' => -1001201590218, 'text' => $request->url() . ' ' . $_SERVER['HTTP_REFERER'] . ' ' . $request->ip()] );
                endif;
            else:
                $telegram = new Telegram('998877864:AAERNdWpQRoJ5j6dNkS3m6ww3Oj2RY1IZrg', false);
                $telegram->endpoint('sendMessage', ['chat_id' => -1001201590218, 'text' => $request->url() . ' ' . $_SERVER['HTTP_REFERER'] . ' ' . $request->ip()]);
            endif;

        } catch (\Exception $e) {

        }


        /* if ($exception instanceof \ErrorException) {
          return response()->view('errors.500', [], 500);
      }else{*/
        return parent::render($request, $exception);
        //}
    }
}
