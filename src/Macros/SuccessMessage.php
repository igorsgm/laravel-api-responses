<?php

namespace Igorsgm\LaravelApiResponses\Macros;

use Igorsgm\LaravelApiResponses\ResponseMacroInterface;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Routing\ResponseFactory;

class SuccessMessage implements ResponseMacroInterface
{
    /**
     * @param  ResponseFactory  $factory
     */
    public function run($factory)
    {
        $factory->macro('successMessage',
            /**
             * Return a success JSON message response from the application.
             * Called like: response()->successMessage(...)
             *
             * @param  string  $message
             * @param  int  $status
             * @param  array  $headers
             * @return \Illuminate\Http\JsonResponse
             */
            function ($message = '', $status = HttpResponse::HTTP_OK, array $headers = []) use ($factory) {
                return $factory->success([], $message, $status, $headers);
            });
    }
}
