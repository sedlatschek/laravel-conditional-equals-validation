<?php

use Illuminate\Support\Facades\Validator;
use Sedlatschek\ConditionalEqualsValidation\Rules\Equals;

it('works with only any conditions', function (array $rules, array $data, bool $expected) {
    $this->post('/test', $data);
    $validator = Validator::make($data, $rules);
    expect($validator->passes())->toBe($expected);
})->with([
    [
        [
            'a' => (new Equals(1))->if('b', 'X'),
            'b' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 'X',
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->if('b', 'X'),
            'b' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 'Y',
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->if('b', 'X'),
            'b' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 'X',
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(1))->if('b', 'X'),
            'b' => 'nullable',
        ],
        [
            'a' => false,
            'b' => 'X',
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(1))->if('b', 'X'),
            'b' => 'nullable',
        ],
        [
            'a' => true,
            'b' => 'X',
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(true))->ifAnyOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => true,
            'b' => false,
            'c' => true,
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
            'b' => false,
            'c' => true,
        ],
        false,
    ],
    [
        [
            'a' => (new Equals('Y'))->ifAnyOf(['b', 'c'], 'X'),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 'X',
            'c' => 'X',
        ],
        false,
    ],
    [
        [
            'a' => (new Equals('Y'))->ifAnyOf(['b', 'c'], 'X'),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 'Y',
            'b' => 'X',
            'c' => 'X',
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifAnyOf(['b', 'c'], 2),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 3,
            'c' => 4,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifAnyOf(['b', 'c'], 2),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 2,
            'c' => 2,
        ],
        true,
    ],
]);
