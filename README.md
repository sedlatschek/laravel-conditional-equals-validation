# Laravel Conditional Equals Validation

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sedlatschek/laravel-conditional-equals-validation.svg?style=flat-square)](https://packagist.org/packages/sedlatschek/laravel-conditional-equals-validation)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/sedlatschek/laravel-conditional-equals-validation/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/sedlatschek/laravel-conditional-equals-validation/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/sedlatschek/laravel-conditional-equals-validation/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/sedlatschek/laravel-conditional-equals-validation/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sedlatschek/laravel-conditional-equals-validation.svg?style=flat-square)](https://packagist.org/packages/sedlatschek/laravel-conditional-equals-validation)

This package provides additional validation rules for Laravel projects:

**Equals**

```php
$request->validate([
    'a' => ['boolean', (new Equals(true))->if('b', false)],
    'b' => ['boolean']
]);
```

**NotEquals**

```php
$request->validate([
    'a' => ['string', (new NotEquals('foo'))->ifAnyOf(['b', 'c'], 'bar')],
    'b' => ['string'],
    'c' => ['string'],
]);
```

See [Usage](#usage) for all possibilites! Also know that the native method `Rule::when` may be a better alternative to this package.

## Installation

You can install the package via composer:

```bash
composer require sedlatschek/laravel-conditional-equals-validation
```

## Usage

### If

Evaluate one other fields value.

```php
$request->validate([
    'a' => ['string', (new Equals('foo'))->if('b', 'bar')],
    'b' => ['string'],
]);
```

### IfNot

Evaluate one other fields value.

```php
$request->validate([
    'a' => ['string', (new Equals('foo'))->ifNot('b', 'bar')],
    'b' => ['string'],
]);
```

### IfAllOf

Evaluate if all of the given fields match the given value.

```php
$request->validate([
    'a' => ['string', (new Equals('foo'))->ifAllOf(['b', 'c'], 'bar')],
    'b' => ['string'],
    'c' => ['string'],
]);
```

Example validation results:

```php
// passes
$data = [
    'a' => 'foo',
    'b' => 'bar',
    'c' => 'bar',
];

// fails
$data = [
    'a' => 'x',
    'b' => 'bar',
    'c' => 'bar',
];

// passes
$data = [
    'a' => 'foo',
    'b' => 'bar',
    'c' => 'x',
];
```

### IfAnyOf

Evaluate if any of the given fields match the given value.

```php
$request->validate([
    'a' => ['string', (new Equals('foo'))->ifAnyOf(['b', 'c'], 'bar')],
    'b' => ['string'],
    'c' => ['string'],
]);
```

Example validation results:

```php
// passes
$data = [
    'a' => 'foo',
    'b' => 'bar',
    'c' => 'x',
];

// fails
$data = [
    'a' => 'x',
    'b' => 'bar',
    'c' => 'x',
];

// passes
$data = [
    'a' => 'foo',
    'b' => 'x',
    'c' => 'x',
];
```

### IfNoneOf

Evaluate if none of the given fields match the given value.

```php
$request->validate([
    'a' => ['string', (new Equals('foo'))->ifNoneOf(['b', 'c'], 'bar')],
    'b' => ['string'],
    'c' => ['string'],
]);
```

Example validation results:

```php
// passes
$data = [
    'a' => 'foo',
    'b' => 'x',
    'c' => 'x',
];

// fails
$data = [
    'a' => 'x',
    'b' => 'x',
    'c' => 'x',
];

// passes
$data = [
    'a' => 'foo',
    'b' => 'x',
    'c' => 'bar',
];
```

### Combined

All of the above conditions can be chained. The connection between each condition is seen as an `and` operator.

```php
$request->validate([
    'a' => ['string', (new Equals('foo'))->if('b', 'bar')->ifAnyOf(['c', 'd'], false)->ifAllOf(['e', 'f', 'g'], 1),
    'b' => ['string'],
    'c' => ['boolean'],
    'd' => ['boolean'],
    'e' => ['integer'],
    'f' => ['integer'],
    'g' => ['integer'],
]);
```

Example validation results:

```php
// passes
$data = [
    'a' => 'foo',
    'b' => 'bar',
    'c' => true,
    'd' => false,
    'e' => 1,
    'f' => 1,
    'g' => 1,
];

// fails
$data = [
    'a' => 'x',
    'b' => 'bar',
    'c' => true,
    'd' => false,
    'e' => 1,
    'f' => 1,
    'g' => 1,
];

// passes
$data = [
    'a' => 'x',
    'b' => 'bar',
    'c' => true,
    'd' => false,
    'e' => 1,
    'f' => 1,
    'g' => 2,
];

// passes
$data = [
    'a' => 'x',
    'b' => 'x',
    'c' => true,
    'd' => false,
    'e' => 1,
    'f' => 1,
    'g' => 1,
];

// passes
$data = [
    'a' => 'x',
    'b' => 'x',
    'c' => true,
    'd' => true,
    'e' => 1,
    'f' => 1,
    'g' => 1,
];
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Simon Sedlatschek](https://github.com/sedlatschek)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
