<?php

use Illuminate\Support\Facades\Validator;
use Sedlatschek\ConditionalEqualsValidation\Rules\Equals;

it('handles undefined parameters the right way', function (array $rules, array $data, bool $expected) {
    $this->post('/test', $data);
    $validator = Validator::make($data, $rules);
    expect($validator->passes())->toBe($expected);
})->with([
    // -> if
    [
        [
            'a' => (new Equals(1))->if('b', 1),
            'b' => 'nullable',
        ],
        [
            'a' => 1,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->if('b', 1),
            'b' => 'nullable',
        ],
        [
            'a' => 2,
        ],
        true,
    ],
    // -> if not
    [
        [
            'a' => (new Equals(1))->ifNot('b', 1),
            'b' => 'nullable',
        ],
        [
            'a' => 1,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifNot('b', 1),
            'b' => 'nullable',
        ],
        [
            'a' => 2,
        ],
        false,
    ],
    // -> if all of
    [
        [
            'a' => (new Equals(1))->ifAllOf(['b', 'c'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 1,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifAllOf(['b', 'c'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 1,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifAllOf(['b', 'c'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 2,
        ],
        true,
    ],
    // -> if any of
    [
        [
            'a' => (new Equals(1))->ifAnyOf(['b', 'c'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 1,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifAnyOf(['b', 'c'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 1,
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(1))->ifAnyOf(['b', 'c'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 2,
        ],
        true,
    ],
    // -> if none of
    [
        [
            'a' => (new Equals(1))->ifNoneOf(['b', 'c'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 1,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifNoneOf(['b', 'c'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 1,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifNoneOf(['b', 'c'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 2,
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(1))->ifNoneOf(['b', 'c'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 1,
        ],
        true,
    ],
]);
