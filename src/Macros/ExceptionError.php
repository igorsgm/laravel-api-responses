<?php

namespace Igorsgm\LaravelApiResponses\Macros;

use Igorsgm\LaravelApiResponses\ResponseMacroInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ExceptionError implements ResponseMacroInterface
{
    /**
     * @param  ResponseFactory  $factory
     */
    public function run($factory)
    {
        $factory->macro('exceptionError',
            /**
             * Return a new error JSON response from the application coming from an exception.
             * Called like: response()->exceptionError(...)
             *
             * @param  Throwable  $e
             * @param  string  $message
             * @param  int  $status
             * @param  array  $headers
             * @return JsonResponse
             */
            function ($e, $message = '', $status = 0, array $headers = []) use ($factory) {
                $errors = method_exists($e, 'errors') ? $e->errors() : [];

                if (empty($message)) {
                    $showExceptionMessage = config('app.debug') || $e instanceof HttpExceptionInterface;
                    $message = $showExceptionMessage ? $e->getMessage() : 'Server Error';
                }

                $status = !empty($status) ? (int) $status : $e->getCode();

                $debugData = [];
                if (config('app.debug')) {
                    $debugData = [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => ExceptionError::treatTraceData($e),
                    ];
                }

                return $factory->error($errors, $message, $status, $headers, $debugData);
            });
    }

    /**
     * Filtering exception's trace to show the data that matters more
     * @param  Throwable  $e
     * @return array
     */
    public static function treatTraceData($e)
    {
        $traceAsString = explode("\n", $e->getTraceAsString());
        $trace = collect($e->getTrace());

        if (!config('laravel-api-responses.treat_exception_trace')) {
            return $trace->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all();
        }

        return $trace->transform(function ($trace, $key) use ($traceAsString) {
            if ($key == 0 || !isset($trace['file']) || Str::contains($traceAsString[$key], 'App\\') ||
                !Str::contains($trace['file'], ['vendor/', '/public/index.php', ' phar://', "#1 "])
            ) {
                unset($trace['type']);
                if (isset($trace['args'])) {
                    $trace['args'] = json_decode(json_encode($trace['args']), true);
                    $trace['args'] = self::arrayFilterRecursive($trace['args']);

                    if (empty($trace['args'])) {
                        unset($trace['args']);
                    }
                }

                return $trace;
            }
        })->filter()->toArray();
    }

    /**
     * Removes empty elements of an array recursively
     *
     * @param  array  $array
     * @return array
     */
    public static function arrayFilterRecursive($array): array
    {
        if (!is_array($array)) {
            return [];
        }

        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = self::arrayFilterRecursive($value);
            }
        }
        return array_filter($array, function ($var) {
            return !empty($var);
        });
    }
}
