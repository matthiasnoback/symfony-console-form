<?php

declare(strict_types=1);

namespace Matthias\SymfonyConsoleForm\Tests\Command;

use Matthias\SymfonyConsoleForm\Console\Command\FormBasedCommandWithDefault;
use Matthias\SymfonyConsoleForm\Tests\Form\Data\Address;

class DefaultFormDataCommand extends PrintFormDataCommand implements FormBasedCommandWithDefault
{
    public function getFormDefault()
    {
        return new Address('already save address');
    }
}
