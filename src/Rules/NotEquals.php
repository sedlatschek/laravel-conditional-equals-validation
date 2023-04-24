<?php

namespace Sedlatschek\ConditionalEqualsValidation\Rules;

use Sedlatschek\ConditionalEqualsValidation\ConditionalRule;

class NotEquals extends ConditionalRule
{
    /**
     * Determine whether or not the conditions need to be checked using the rule value and the actual value.
     */
    protected function needsToHaveConditionsChecked(mixed $ruleValue, mixed $actualValue): bool
    {
        return $ruleValue === $actualValue;
    }
}
