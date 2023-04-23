<?php

use Illuminate\Support\Facades\Validator;
use Sedlatschek\ConditionalEqualsValidation\Rules\Equals;

it('handles null the right way', function (array $rules, array $data, bool $expected) {
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
            'a' => 2,
            'b' => null,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->if('b', null),
            'b' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => null,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->if('b', null),
            'b' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => null,
        ],
        false,
    ],
    // -> if not
    [
        [
            'a' => (new Equals(1))->ifNot('b', 1),
            'b' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => null,
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
            'b' => null,
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(1))->ifNot('b', null),
            'b' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 1,
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(1))->ifNot('b', null),
            'b' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => null,
        ],
        true,
    ],
    // -> if all of
    [
        [
            'a' => (new Equals(true))->ifAllOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => false,
            'b' => null,
            'c' => null,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(true))->ifAllOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => false,
            'b' => null,
            'c' => true,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(true))->ifAllOf(['b', 'c'], null),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => false,
            'b' => null,
            'c' => null,
        ],
        false,
    ],
    // -> if any of
    [
        [
            'a' => (new Equals(true))->ifAnyOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => false,
            'b' => null,
            'c' => null,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(true))->ifAnyOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => false,
            'b' => null,
            'c' => null,
        ],
        true,
    ],
    // -> if none of
    [
        [
            'a' => (new Equals(true))->ifNoneOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => true,
            'b' => null,
            'c' => null,
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
            'b' => null,
            'c' => null,
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(true))->ifNoneOf(['b', 'c'], null),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => false,
            'b' => null,
            'c' => null,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(true))->ifNoneOf(['b', 'c'], null),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => true,
            'b' => null,
            'c' => null,
        ],
        true,
    ],
]);
