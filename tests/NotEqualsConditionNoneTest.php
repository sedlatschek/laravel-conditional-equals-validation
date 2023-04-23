<?php

use Illuminate\Support\Facades\Validator;
use Sedlatschek\ConditionalEqualsValidation\Rules\NotEquals;

it('validates "equals" with only "none" conditions', function (array $rules, array $data, bool $expected) {
    $this->post('/test', $data);
    $validator = Validator::make($data, $rules);
    expect($validator->passes())->toBe($expected);
})->with([
    [
        [
            'a' => (new NotEquals(1))->ifNot('b', 1),
            'b' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 3,
        ],
        false,
    ],
    [
        [
            'a' => (new NotEquals(1))->ifNot('b', 1),
            'b' => 'nullable',
        ],
        [
            'a' => 4,
            'b' => 1,
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals(1))->ifNot('b', 1),
            'b' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 2,
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals('Z'))->ifNoneOf(['b', 'c'], 3),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 'Z',
            'b' => 3,
            'c' => 3,
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals('Z'))->ifNoneOf(['b', 'c'], 3),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 'Z',
            'b' => 2,
            'c' => 1,
        ],
        false,
    ],
    [
        [
            'a' => (new NotEquals('Z'))->ifNoneOf(['b', 'c'], 3),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 'X',
            'b' => 2,
            'c' => 1,
        ],
        true,
    ],
]);
