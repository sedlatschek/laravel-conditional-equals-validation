<?php

use Illuminate\Support\Facades\Validator;
use Sedlatschek\ConditionalEqualsValidation\Rules\Equals;

it('validates "equals" with only "none" conditions', function (array $rules, array $data, bool $expected) {
    $this->post('/test', $data);
    $validator = Validator::make($data, $rules);
    expect($validator->passes())->toBe($expected);
})->with([
    [
        [
            'a' => (new Equals(1))->ifNot('b', 1),
            'b' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 3,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifNot('b', 1),
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
            'a' => (new Equals(1))->ifNot('b', 1),
            'b' => 'nullable',
        ],
        [
            'a' => 5,
            'b' => 2,
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(true))->ifNoneOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => true,
            'b' => false,
            'c' => false,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(true))->ifNoneOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => false,
            'b' => false,
            'c' => false,
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(true))->ifNoneOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => true,
            'b' => false,
            'c' => false,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(true))->ifNoneOf(['b', 'c'], true),
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
            'a' => (new Equals(true))->ifNoneOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => true,
            'b' => true,
            'c' => false,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifNoneOf(['b', 'c'], 2),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 2,
            'c' => 'X',
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifNoneOf(['b', 'c'], 2),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => '1',
            'b' => 2,
            'c' => 'X',
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifNoneOf(['b', 'c'], 2),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 'X',
            'c' => 'X',
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifNoneOf(['b', 'c'], 2),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 'X',
            'c' => 'X',
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(1))->ifNoneOf(['b', 'c'], 2),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 'X',
            'c' => 'X',
        ],
        true,
    ],
]);
