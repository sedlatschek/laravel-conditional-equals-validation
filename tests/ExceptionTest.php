<?php

use Illuminate\Support\Facades\Validator;
use Sedlatschek\ConditionalEqualsValidation\InvalidRuleDefinitionException;
use Sedlatschek\ConditionalEqualsValidation\Rules\Equals;

it('throws exception if a field is self referencing', function (array $rules, array $data) {
    $this->post('/test', $data);
    $validator = Validator::make($data, $rules);

    expect(fn () => $validator->passes())->toThrow(InvalidRuleDefinitionException::class);
})->with([
    [
        [
            'a' => (new Equals(1))->if('a', 'X'),
        ],
        [
            'a' => 1,
        ],
    ],
    [
        [
            'a' => (new Equals(1))->if('b', 'X')->ifNot('c', 3)->ifNoneOf(['a', 'b', 'c'], null),
        ],
        [
            'a' => 1,
            'b' => null,
            'c' => '*',
        ],
    ],
    [
        [
            'a' => (new Equals(1))->ifAllOf(['c', 'a'], 1),
        ],
        [
            'a' => '1',
        ],
    ],
]);
