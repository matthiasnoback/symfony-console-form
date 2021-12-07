<?php

declare(strict_types=1);

namespace Matthias\SymfonyConsoleForm\Console\Command;

interface FormBasedCommandWithDefault
{
    /**
     * Returning default data of a form
     *
     * @return mixed
     */
    public function getFormDefault();
}
