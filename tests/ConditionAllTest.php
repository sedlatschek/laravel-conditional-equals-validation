<?php

use Illuminate\Support\Facades\Validator;
use Sedlatschek\ConditionalEqualsValidation\Rules\Equals;

it('works with only all conditions', function (array $rules, array $data, bool $expected) {
    $this->post('/test', $data);
    $validator = Validator::make($data, $rules);
    expect($validator->passes())->toBe($expected);
})->with([
    [
        [
            'a' => (new Equals(true))->ifAllOf(['b', 'c'], true),
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
            'a' => (new Equals(true))->ifAllOf(['b', 'c'], true),
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
            'a' => (new Equals(true))->ifAllOf(['b', 'c'], true),
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
    [
        [
            'a' => (new Equals(true))->ifAllOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => true,
            'b' => true,
            'c' => true,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(true))->ifAllOf(['b', 'c'], 'X'),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => true,
            'b' => 'X',
            'c' => 'Y',
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(true))->ifAllOf(['b', 'c'], 'X'),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => false,
            'b' => 'X',
            'c' => 'Y',
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(true))->ifAllOf(['b', 'c'], 'X'),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => false,
            'b' => 'X',
            'c' => 'X',
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(true))->ifAllOf(['b', 'c'], 'X'),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => true,
            'b' => 'X',
            'c' => 'X',
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(true))->ifAllOf(['b', 'c'], 'X'),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 'X',
            'b' => 'X',
            'c' => 'X',
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(1))->ifAllOf(['b', 'c'], 'X'),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => '1',
            'b' => 'X',
            'c' => 'X',
        ],
        false,
    ],
]);
