<?php

namespace Sedlatschek\ConditionalEqualsValidation\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Sedlatschek\ConditionalEqualsValidation\ConditionalEqualsValidationServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        \Illuminate\Support\Facades\Route::get('/test', fn () => null);
    }

    protected function getPackageProviders($app)
    {
        return [
            ConditionalEqualsValidationServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
