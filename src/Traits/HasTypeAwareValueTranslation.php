<?php

namespace Sedlatschek\ConditionalEqualsValidation\Traits;

trait HasTypeAwareValueTranslation
{
    /**
     * Translate boolean/null values.
     * If no boolean or null value is passed, the given value is returned unchanged.
     */
    protected function translateValue(mixed $value): mixed
    {
        if ($value === null) {
            return __('conditional-equals-validation::messages.null');
        }
        if ($value === true) {
            return __('conditional-equals-validation::messages.true');
        }
        if ($value === false) {
            return __('conditional-equals-validation::messages.false');
        }

        return $value;
    }
}
