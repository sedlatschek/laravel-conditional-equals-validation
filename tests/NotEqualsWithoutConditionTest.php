<?php

use Illuminate\Support\Facades\Validator;
use Sedlatschek\ConditionalEqualsValidation\Rules\NotEquals;

it('validations "not equals" without conditions', function (array $rules, array $data, bool $expected) {
    $validator = Validator::make($data, $rules);
    expect($validator->passes())->toBe($expected);
})->with([
    [
        [
            'a' => (new NotEquals(true)),
        ],
        [
            'a' => true,
        ],
        false,
    ],
    [
        [
            'a' => (new NotEquals(true)),
        ],
        [
            'a' => false,
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals(true)),
        ],
        [
            'a' => 'X',
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals(true)),
        ],
        [
            'a' => 1,
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals(1)),
        ],
        [
            'a' => 1,
        ],
        false,
    ],
    [
        [
            'a' => (new NotEquals(1)),
        ],
        [
            'a' => true,
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals('X')),
        ],
        [
            'a' => true,
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals('X')),
        ],
        [
            'a' => 'X',
        ],
        false,
    ],
    [
        [
            'a' => (new NotEquals('X')),
        ],
        [
            'a' => 1,
        ],
        true,
    ],
]);
