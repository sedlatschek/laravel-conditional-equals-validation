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

    protected mixed $value;

    public function __construct(array $parameters, mixed $value)
    {
        $this->parameters = collect($parameters);
        $this->value = $value;
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

    /**
     * Serialize parameters to use "," and "and".
     */
    protected function serializeParameters(): string
    {
        $uniqueParameters = $this->parameters->unique()->values();

        if (count($uniqueParameters) <= 0) {
            return '';
        }

        if (count($uniqueParameters) === 1) {
            return $uniqueParameters[0];
        }

        return $uniqueParameters->slice(0, count($uniqueParameters) - 1)
            ->join(', ')
            .' '
            .__('conditional-equals-validation::messages.and')
            .' '
            .$uniqueParameters->last();
    }

    abstract public function validate(Request $request): bool;

    abstract public function message(): string;
}
