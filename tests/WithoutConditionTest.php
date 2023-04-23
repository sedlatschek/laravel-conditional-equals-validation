<?php

use Illuminate\Support\Facades\Validator;
use Sedlatschek\ConditionalEqualsValidation\Rules\Equals;

it('works without condition', function (array $rules, array $data, bool $expected) {
    $validator = Validator::make($data, $rules);
    expect($validator->passes())->toBe($expected);
})->with([
    [
        [
            'a' => (new Equals(true)),
        ],
        [
            'a' => true,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(true)),
        ],
        [
            'a' => false,
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(true)),
        ],
        [
            'a' => 'X',
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(true)),
        ],
        [
            'a' => 1,
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(1)),
        ],
        [
            'a' => 1,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1)),
        ],
        [
            'a' => true,
        ],
        false,
    ],
    [
        [
            'a' => (new Equals('X')),
        ],
        [
            'a' => true,
        ],
        false,
    ],
    [
        [
            'a' => (new Equals('X')),
        ],
        [
            'a' => 'X',
        ],
        true,
    ],
    [
        [
            'a' => (new Equals('X')),
        ],
        [
            'a' => 1,
        ],
        false,
    ],
]);
