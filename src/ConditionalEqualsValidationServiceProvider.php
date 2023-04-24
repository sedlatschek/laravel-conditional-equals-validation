<?php

namespace Sedlatschek\ConditionalEqualsValidation;

use Illuminate\Support\ServiceProvider;

class ConditionalEqualsValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'conditional-equals-validation');
    }
}
