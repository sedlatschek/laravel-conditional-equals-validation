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

    protected mixed $equals;

    public function __construct(array $parameters, mixed $equals)
    {
        $this->parameters = collect($parameters);
        $this->equals = $equals;
    }

    /**
     * Get all the parameters the condition uses for comparison.
     *
     * @return \Illuminate\Support\Collection<string>
     */
    public function getParameters(): Collection
    {
        return $this->parameters;
    }

    abstract public function validate(Request $request): bool;
}
