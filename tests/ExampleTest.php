<?php

namespace Igorsgm\LaravelApiResponses\Tests;

use Orchestra\Testbench\TestCase;
use Igorsgm\LaravelApiResponses\LaravelApiResponsesServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelApiResponsesServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
