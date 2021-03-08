<?php

namespace Igorsgm\LaravelApiResponses\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // First, set the header so any other middleware knows we're
        // dealing with a should-be JSON response.
        $request->headers->set('Accept', 'application/json');

        // Get the response
        $response = $next($request);

        if (!empty($response->exception)) {
            return response()
                ->exceptionError($response->exception, '', $response->status(), $response->headers->all());
        }

        // If the response is not strictly a JsonResponse, we make it
        if (!$response instanceof JsonResponse) {
            return response()
                ->success($response->content(), '', $response->status(), $response->headers->all());
        }

        return $response;
    }
}
