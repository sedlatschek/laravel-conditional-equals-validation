<?php

use Illuminate\Support\Facades\Validator;
use Sedlatschek\ConditionalEqualsValidation\Rules\Equals;
use Sedlatschek\ConditionalEqualsValidation\Rules\NotEquals;

it('works when multiple conditions are combined', function (array $rules, array $data, bool $expected) {
    $this->post('/test', $data);
    $validator = Validator::make($data, $rules);
    expect($validator->passes())->toBe($expected);
})->with([
    [
        [
            'a' => (new Equals(1))->if('b', 'X')->ifNot('c', 'Y'),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 'X',
            'c' => 'Y',
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->if('b', 'X')->ifNot('c', 'Y'),
            'b' => 'nullable',
            'c' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 'X',
            'c' => 'Y',
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->if('b', 'X')->ifNot('c', 'Y'),
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
            'a' => (new Equals(1))->if('b', 'X')->ifNot('c', 'Y'),
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
            'a' => (new Equals(1))->if('b', 'X')->ifAnyOf(['c', 'd'], 'Y')->ifAllOf(['e', 'f'], 2),
            'b' => 'nullable',
            'c' => 'nullable',
            'd' => 'nullable',
            'e' => 'nullable',
            'f' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 'X',
            'c' => 'X',
            'd' => 'X',
            'e' => 1,
            'f' => 2,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->if('b', 'X')->ifAnyOf(['c', 'd'], 'Y')->ifAllOf(['e', 'f'], 2),
            'b' => 'nullable',
            'c' => 'nullable',
            'd' => 'nullable',
            'e' => 'nullable',
            'f' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 'X',
            'c' => 'X',
            'd' => 'X',
            'e' => 2,
            'f' => 2,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->if('b', 'X')->ifAnyOf(['c', 'd'], 'Y')->ifAllOf(['e', 'f'], 2),
            'b' => 'nullable',
            'c' => 'nullable',
            'd' => 'nullable',
            'e' => 'nullable',
            'f' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 'X',
            'c' => 'X',
            'd' => 'Y',
            'e' => 2,
            'f' => 2,
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(1))->ifNot('b', 'Y')->ifNoneOf(['c', 'd'], 'X')->ifAllOf(['e', 'f'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
            'd' => 'nullable',
            'e' => 'nullable',
            'f' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 'X',
            'c' => 'Y',
            'd' => 'Y',
            'e' => 1,
            'f' => 1,
        ],
        false,
    ],
    [
        [
            'a' => (new Equals(1))->ifNot('b', 'Y')->ifNoneOf(['c', 'd'], 'X')->ifAllOf(['e', 'f'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
            'd' => 'nullable',
            'e' => 'nullable',
            'f' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 'X',
            'c' => 'Y',
            'd' => 'Y',
            'e' => 1,
            'f' => 1,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifNot('b', 'Y')->ifNoneOf(['c', 'd'], 'X')->ifAllOf(['e', 'f'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
            'd' => 'nullable',
            'e' => 'nullable',
            'f' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 'Y',
            'c' => 'Y',
            'd' => 'Y',
            'e' => 1,
            'f' => 1,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifNot('b', 'Y')->ifNoneOf(['c', 'd'], 'X')->ifAllOf(['e', 'f'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
            'd' => 'nullable',
            'e' => 'nullable',
            'f' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 'X',
            'c' => 'Y',
            'd' => 'X',
            'e' => 1,
            'f' => 1,
        ],
        true,
    ],
    [
        [
            'a' => (new Equals(1))->ifNot('b', 'Y')->ifNoneOf(['c', 'd'], 'X')->ifAllOf(['e', 'f'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
            'd' => 'nullable',
            'e' => 'nullable',
            'f' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 'X',
            'c' => 'Y',
            'd' => 'Y',
        ],
        true,
    ],
    [
        [
            'a' => (new NotEquals(1))->if('b', 'Y')->ifNoneOf(['c', 'd'], 'X')->ifAllOf(['e', 'f'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
            'd' => 'nullable',
            'e' => 'nullable',
            'f' => 'nullable',
        ],
        [
            'a' => 1,
            'b' => 'Y',
            'c' => 'Y',
            'd' => 'Y',
            'e' => 1,
            'f' => 1,
        ],
        false,
    ],
    [
        [
            'a' => (new NotEquals(1))->if('b', 'Y')->ifNoneOf(['c', 'd'], 'X')->ifAllOf(['e', 'f'], 1),
            'b' => 'nullable',
            'c' => 'nullable',
            'd' => 'nullable',
            'e' => 'nullable',
            'f' => 'nullable',
        ],
        [
            'a' => 2,
            'b' => 'Y',
            'c' => 'Y',
            'd' => 'Y',
            'e' => 1,
            'f' => 1,
        ],
        true,
    ],
]);
