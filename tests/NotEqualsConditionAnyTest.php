<?php

use Illuminate\Support\Facades\Validator;
use Sedlatschek\ConditionalEqualsValidation\Rules\NotEquals;

it('validates "not equals" with only "any" conditions', function (array $rules, array $data, bool $expected) {
    $this->post('/test', $data);
    $validator = Validator::make($data, $rules);
    expect($validator->passes())->toBe($expected);
})->with([
    [
        [
            'a' => (new NotEquals(1))->if('b', 'X'),
            'b' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 'X',
        ],
        false,
    ],
    [
        [
            'a' => (new NotEquals(1))->if('b', 'X'),
            'b' => 'nullable',
        ],
        [
            'a' => '1',
            'b' => 'X',
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals(true))->ifAnyOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => true,
            'b' => false,
            'c' => true,
        ],
        false,
    ],
    [
        [
            'a' => (new NotEquals(true))->ifAnyOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => false,
            'b' => true,
            'c' => false,
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals(false))->ifAnyOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => false,
            'b' => true,
            'c' => true,
        ],
        false,
    ],
]);
