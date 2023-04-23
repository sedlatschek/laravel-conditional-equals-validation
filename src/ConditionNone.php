<?php

namespace Sedlatschek\ConditionalEqualsValidation;

use Illuminate\Http\Request;

class ConditionNone extends Condition
{
    /**
     * Define under which condition a value other than the `$mustBe` value
     * is allowed.
     */
    public function allowsDifferentValue(Request $request): bool
    {
        return $this->parameters->some(
            fn ($p) => $request->has($p) && $request->{$p} === $this->equals
        );
    }
}
