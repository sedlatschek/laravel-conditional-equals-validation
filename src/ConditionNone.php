<?php

namespace Sedlatschek\ConditionalEqualsValidation;

use Illuminate\Http\Request;

class ConditionNone extends Condition
{
     public function validate(Request $request): bool
    {
        return $this->parameters->some(
            fn ($p) => $request->has($p) && $request->{$p} === $this->equals
        );
    }
}
