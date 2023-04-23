<?php

namespace Sedlatschek\ConditionalEqualsValidation\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sedlatschek\ConditionalEqualsValidation\ConditionalEqualsValidation
 */
class ConditionalEqualsValidation extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Sedlatschek\ConditionalEqualsValidation\ConditionalEqualsValidation::class;
    }
}
