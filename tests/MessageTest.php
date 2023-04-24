<?php

use Illuminate\Support\Facades\Validator;
use Sedlatschek\ConditionalEqualsValidation\Rules\Equals;

it('prints message', function (array $rules, array $data, string $message) {
    $this->post('/test', $data);
    $validator = Validator::make($data, $rules);
    expect($validator->errors()->get('a')[0])->toBe($message);
})->with([
    [
        [
            'a' => (new Equals(1)),
        ],
        [
            'a' => 2,
        ],
        'a must be 1',
    ],
    [
        [
            'a' => (new Equals(1))->ifNot('b', 3),
        ],
        [
            'a' => 2,
        ],
        'a must be 1 if b is not 3',
    ],
    [
        [
            'a' => (new Equals(1))->ifNot('b', 3)->ifAnyOf(['c', 'd'], 4)->ifAllOf(['e', 'f'], 5)->ifNoneOf(['g', 'h', 'i'], 6),
        ],
        [
            'a' => 9,
            'c' => 4,
            'd' => 1,
            'e' => 5,
            'f' => 5,
            'g' => 5,
            'h' => 7,
        ],
        'a must be 1 if b is not 3 and if any of c and d are 4 and if all of e and f are 5 and if non of g, h and i are 6',
    ],
    [
        [
            'a' => (new Equals(true))->ifNot('b', false),
            'b' => 'boolean',
        ],
        [
            'a' => false,
            'b' => true,
        ],
        'a must be true if b is not false',
    ],
    [
        [
            'a' => (new Equals(null))->if('b', null),
            'b' => 'boolean',
        ],
        [
            'a' => 1,
            'b' => null,
        ],
        'a must be empty if b is empty',
    ],
]);
