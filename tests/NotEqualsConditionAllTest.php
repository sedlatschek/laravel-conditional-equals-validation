<?php

use Illuminate\Support\Facades\Validator;
use Sedlatschek\ConditionalEqualsValidation\Rules\NotEquals;

it('validates "not equals" with only "all" conditions', function (array $rules, array $data, bool $expected) {
    $this->post('/test', $data);
    $validator = Validator::make($data, $rules);
    expect($validator->passes())->toBe($expected);
})->with([
    [
        [
            'a' => (new NotEquals(true))->ifAllOf(['b', 'c'], true),
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
            'a' => (new NotEquals(true))->ifAllOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => false,
            'b' => true,
            'c' => true,
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals(true))->ifAllOf(['b', 'c'], true),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => true,
            'b' => true,
            'c' => true,
        ],
        false,
    ],
    [
        [
            'a' => (new NotEquals(true))->ifAllOf(['b', 'c'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => true,
            'b' => 0,
            'c' => true,
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals(true))->ifAllOf(['b', 'c'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 1,
            'c' => '1',
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals(true))->ifAllOf(['b', 'c'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 1,
            'c' => 1,
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals(true))->ifAllOf(['b', 'c'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => true,
            'b' => 1,
            'c' => 1,
        ],
        false,
    ],
]);
