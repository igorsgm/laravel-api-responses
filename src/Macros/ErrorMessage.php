<?php

namespace Igorsgm\LaravelApiResponses\Macros;

use Igorsgm\LaravelApiResponses\ResponseMacroInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Routing\ResponseFactory;

class ErrorMessage implements ResponseMacroInterface
{
    /**
     * @param  ResponseFactory  $factory
     */
    public function run($factory)
    {
        $factory->macro('errorMessage',
            /**
             * Return an error JSON message from the application.
             * Called like: response()->successMessage(...)
             *
             * @param  string  $message
             * @param  int  $status
             * @param  array  $headers
             * @return JsonResponse
             */
            function ($message = '', $status = HttpResponse::HTTP_INTERNAL_SERVER_ERROR, array $headers = []) use (
                $factory
            ) {
                return $factory->error([], $message, $status, $headers);
            });
    }
}
