<?php

namespace Sedlatschek\ConditionalEqualsValidation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Sedlatschek\ConditionalEqualsValidation\Condition;
use Sedlatschek\ConditionalEqualsValidation\ConditionAll;
use Sedlatschek\ConditionalEqualsValidation\ConditionAny;
use Sedlatschek\ConditionalEqualsValidation\ConditionNone;

class Equals implements ValidationRule
{
    /**
     * @var \Illuminate\Support\Collection<\Sedlatschek\BooleanValidation\Condition>
     */
    protected Collection $conditions;

    protected $mustBe;

    public function __construct($value)
    {
        $this->conditions = collect();
        $this->mustBe = $value;
    }

    /**
     * @param  string[]  $parameters
     */
    public function ifAnyOf(array $parameters, $equals): Equals
    {
        $this->conditions->push(new ConditionAny($parameters, $equals));

        return $this;
    }

    /**
     * @param  string[]  $parameters
     */
    public function ifAllOf(array $parameters, $equals): Equals
    {
        $this->conditions->push(new ConditionAll($parameters, $equals));

        return $this;
    }

    /**
     * @param  string[]  $parameters
     */
    public function ifNoneOf(array $parameters, $equals): Equals
    {
        $this->conditions->push(new ConditionNone($parameters, $equals));

        return $this;
    }

    public function if(string $parameter, $equals): Equals
    {
        return $this->ifAnyOf([$parameter], $equals);
    }

    public function ifNot(string $parameter, $equals): Equals
    {
        return $this->ifNoneOf([$parameter], $equals);
    }

    /**
     * @return  \Illuminate\Support\Collection<\Sedlatschek\BooleanValidation\AllCondition>
     */
    protected function getAllConditions(): Collection
    {
        return $this->conditions->filter(
            fn (Condition $condition) => get_class($condition) === ConditionAll::class,
        );
    }

    /**
     * @return  \Illuminate\Support\Collection<\Sedlatschek\BooleanValidation\AllCondition>
     */
    protected function getAnyConditions(): Collection
    {
        return $this->conditions->filter(
            fn (Condition $condition) => get_class($condition) === ConditionAny::class,
        );
    }

    /**
     * @return  \Illuminate\Support\Collection<\Sedlatschek\BooleanValidation\AllCondition>
     */
    protected function getNoneConditions(): Collection
    {
        return $this->conditions->filter(
            fn (Condition $condition) => get_class($condition) === ConditionNone::class,
        );
    }

    /**
     * @param  \Illuminate\Support\Collection<\Sedlatschek\BooleanValidation\AllCondition>  $collection
     */
    protected function validateCollection(Collection $collection, Request $request): bool
    {
        return $collection->every(
            fn (Condition $condition) => $condition->allowsDifferentValue($request)
        );
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $request = request();

        if ($value !== $this->mustBe) {
            if (count($this->conditions) === 0) {
                $fail('fails even without condition');
            } elseif (! $this->validateCollection($this->getAllConditions(), $request)) {
                $fail('all failed');
            } elseif (! $this->validateCollection($this->getAnyConditions(), $request)) {
                $fail('any failed');
            } elseif (! $this->validateCollection($this->getNoneConditions(), $request)) {
                $fail('none failed');
            }
        }
    }
}
