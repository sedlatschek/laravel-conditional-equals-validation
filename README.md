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

See [Usage](#usage) for all possibilites! Also know that the native method `Rule::when` may be a better alternative to this package.

## Installation

You can install the package via composer:

```bash
composer require sedlatschek/laravel-conditional-equals-validation
```

## Usage

```php
$conditionalEqualsValidation = new Sedlatschek\ConditionalEqualsValidation();
echo $conditionalEqualsValidation->echoPhrase('Hello, Sedlatschek!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Simon Sedlatschek](https://github.com/sedlatschek)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
