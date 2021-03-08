<?php

namespace Igorsgm\LaravelApiResponses;

use Illuminate\Routing\ResponseFactory;

interface ResponseMacroInterface
{
    /**
     * Run.
     * @param ResponseFactory $factory
     */
    public function run($factory);
}
