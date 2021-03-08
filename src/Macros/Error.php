<?php

namespace Igorsgm\LaravelApiResponses\Macros;

use Igorsgm\LaravelApiResponses\ResponseMacroInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Routing\ResponseFactory;

class Error implements ResponseMacroInterface
{
    /**
     * @param  ResponseFactory  $factory
     */
    public function run($factory)
    {
        $factory->macro('error',
            /**
             * Return a new error JSON response from the application.
             * Called like: response()->error(...)
             *
             * @param  array  $errors
             * @param  string  $message
             * @param  int  $status
             * @param  array  $headers
             * @param  array  $debugData
             * @return JsonResponse
             */
            function (
                $errors = [],
                $message = '',
                $status = HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                array $headers = [],
                $debugData = []
            ) use ($factory) {
                $response = [
                    'success' => false,
                    'message' => !empty($message) ? $message : 'Server error',
                    'status' => !empty($status) ? $status : HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                ];

                if (!empty($errors)) {
                    $response['errors'] = $errors;
                }

                if (!empty($debugData) && config('app.debug')) {
                    $response['debug'] = $debugData;
                }

                return $factory->json($response, $response['status'], $headers);
            });
    }
}
