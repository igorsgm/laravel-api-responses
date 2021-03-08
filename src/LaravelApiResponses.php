<?php

namespace Igorsgm\LaravelApiResponses;

use Illuminate\Contracts\Routing\ResponseFactory;

class LaravelApiResponses
{
    /**
     * Macros.
     * @var array
     */
    protected $macros = [];

    /**
     * LaravelApiResponses constructor.
     * @param  ResponseFactory  $factory
     */
    public function __construct(ResponseFactory $factory)
    {
        $this->macros = [
            Macros\Success::class,
            Macros\SuccessMessage::class,
            Macros\Error::class,
            Macros\ErrorMessage::class,
            Macros\ExceptionError::class,
        ];

        $this->bindMacros($factory);
    }

    /**
     * Bind macros.
     * @param  ResponseFactory  $factory
     * @return void
     */
    public function bindMacros($factory)
    {
        foreach ($this->macros as $macro) {
            (new $macro)->run($factory);
        }
    }
}
