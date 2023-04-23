<?php

namespace Sedlatschek\ConditionalEqualsValidation;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

abstract class Condition
{
    /**
     * @var \Illuminate\Support\Collection<string>
     */
    protected Collection $parameters;

    protected $equals;

    public function __construct(array $parameters, $equals)
    {
        $this->parameters = collect($parameters);
        $this->equals = $equals;
    }

    /**
     * Define under which condition a value other than the `$mustBe` value
     * is allowed.
     */
    abstract public function allowsDifferentValue(Request $request): bool;
}
