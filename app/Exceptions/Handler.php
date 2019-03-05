<?php

namespace App\Exceptions;

use App\Helpers\ResponseHelper;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    private $response;
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

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->response = new ResponseHelper();
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if(env('APP_ENV') != 'local') {
            if (app()->bound('sentry') && $this->shouldReport($exception)) {
                app('sentry')->captureException($exception);
            }
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $host = ($request->header()['host'][0]);

        $source = explode('.', $host);
        if($source[0] == 'api'){
            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'message' => 'Request not Found!',
                    'code' => 404
                ], 404);
            }
        }



        return parent::render($request, $exception);
    }
}
