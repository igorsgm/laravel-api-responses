<?php

namespace Igorsgm\LaravelApiResponses\Macros;

use Igorsgm\LaravelApiResponses\ResponseMacroInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\ResponseFactory;

class Success implements ResponseMacroInterface
{
    /**
     * @param  ResponseFactory  $factory
     */
    public function run($factory)
    {
        $factory->macro('success',
            /**
             * Return a new success JSON response from the application.
             * Called like: response()->success(...)
             *
             * @param  array  $data
             * @param  string  $message
             * @param  int  $status
             * @param  array  $headers
             * @return JsonResponse
             */
            function ($data = [], $message = '', $status = HttpResponse::HTTP_OK, array $headers = []) use ($factory) {
                if ($data instanceof LengthAwarePaginator) {
                    $data = $data->toArray();
                }

                if ($data instanceof ResourceCollection || $data instanceof JsonResource) {
                    $resourceResponse = $data->response();
                    $data = (array) $resourceResponse->getData();
                    $status = $resourceResponse->getStatusCode();
                    $headers = array_merge($headers, $resourceResponse->headers->all());
                }

                $response = [
                    'success' => true,
                    'message' => !empty($message) ? $message : 'Data retrieved successfully.',
                    'status' => !empty($status) ? (int) $status : HttpResponse::HTTP_OK,
                    'data' => $data,
                ];

                if (is_array($data) && isset($data['data'])) {
                    unset($response['data']);
                    $response = array_merge($response, $data);
                }
                return $factory->json($response, $response['status'], $headers);
            });
    }
}
