<?php

namespace Sedlatschek\ConditionalEqualsValidation;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Sedlatschek\ConditionalEqualsValidation\Commands\ConditionalEqualsValidationCommand;

class ConditionalEqualsValidationServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-conditional-equals-validation')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-conditional-equals-validation_table')
            ->hasCommand(ConditionalEqualsValidationCommand::class);
    }
}
