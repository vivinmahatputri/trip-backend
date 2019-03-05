<?php
/**
 * Created by PhpStorm.
 * User: eggy
 * Date: 14/09/18
 * Time: 1:28
 */

namespace App\Helpers;


class ResponseHelper
{
    /**
     * @param $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function successResponse($data, $message = "Data successfully retrieved", $code = 200)
    {
        $response = [
            'url' => url()->full(),
            'method' => request()->getMethod(),
            'code' => $code,
            'message' => $message,
            'payload' => $data
        ];

        return response($response, $code);
    }

    /**
     * @param \Exception $exception
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function failedResponse(\Exception $exception)
    {
        $response = [
            'url' => url()->full(),
            'method' => request()->getMethod(),
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ];

        return response($response);
    }

    /**
     * @param $message
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function notFoundResponse($message)
    {
        $response = [
            'url' => url()->full(),
            'method' => request()->getMethod(),
            'code' => 404,
            'message' => $message
        ];

        return response($response, 404);
    }
}