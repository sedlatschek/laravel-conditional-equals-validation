<?php

namespace Sedlatschek\ConditionalEqualsValidation;

use Illuminate\Http\Request;

class ConditionNone extends Condition
{
     public function validate(Request $request): bool
     {
        return $this->parameters->some(
            fn ($p) => $request->has($p) && $request->{$p} === $this->value
        );
    }

    public function message(): string
    {
        if (count($this->parameters) === 1) {
            return __('conditional-equals-validation::messages.if_not', [
                'parameter' => $this->parameters[0],
                'value' => $this->value,
            ]);
        }

        return __('conditional-equals-validation::messages.if_none_of', [
            'parameters' => $this->serializeParameters(),
            'value' => $this->value,
        ]);
    }
}
