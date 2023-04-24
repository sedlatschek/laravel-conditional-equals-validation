<?php

namespace Sedlatschek\ConditionalEqualsValidation;

use Illuminate\Http\Request;

class ConditionAny extends Condition
{
    public function validate(Request $request): bool
    {
        return ! $this->parameters->some(
            fn ($p) => $request->has($p) && $request->{$p} === $this->value
        );
    }

    public function message(): string
    {
        $translatedValue = $this->translateValue($this->value);

        if (count($this->parameters) === 1) {
            return __('conditional-equals-validation::messages.if', [
                'parameter' => $this->serializeParameters(),
                'value' => $translatedValue,
            ]);
        }

        return __('conditional-equals-validation::messages.if_any_of', [
            'parameters' => $this->serializeParameters(),
            'value' => $translatedValue,
        ]);
    }
}
