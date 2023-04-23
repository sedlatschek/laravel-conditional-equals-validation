<?php

namespace Sedlatschek\ConditionalEqualsValidation\Commands;

use Illuminate\Console\Command;

class ConditionalEqualsValidationCommand extends Command
{
    public $signature = 'laravel-conditional-equals-validation';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
