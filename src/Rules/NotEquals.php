<?php

namespace Sedlatschek\ConditionalEqualsValidation\Rules;

use Closure;
use Sedlatschek\ConditionalEqualsValidation\Condition;
use Sedlatschek\ConditionalEqualsValidation\ConditionalRule;

class NotEquals extends ConditionalRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->checkForSelfReference($attribute);

        $request = request();

        if ($value === $this->value) {
            if (count($this->conditions) === 0) {
                $fail('fails even without condition');
            } else {
                $failing = $this->conditions->filter(
                    fn (Condition $condition) => ! $condition->validate($request)
                );

                if (count($this->conditions) === count($failing)) {
                    $fail('x');
                }
            }
        }
    }
}
