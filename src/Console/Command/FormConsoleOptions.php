<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

use Symfony\Component\Console\Input\InputOption;

class FormConsoleOptions
{
    /**
     * @return InputOption[]
     */
    public static function getBasicOptions()
    {
        return [
            new InputOption('json-data', 'j', InputOption::VALUE_OPTIONAL, 'Submit a form at once (json format)'),
            new InputOption('json-data-file', null, InputOption::VALUE_OPTIONAL, 'Submit a form at once (json format) from a file'),
        ];
    }
}
