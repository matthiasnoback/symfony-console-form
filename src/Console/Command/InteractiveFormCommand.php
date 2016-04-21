<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

use Symfony\Component\Console\Command\Command;

abstract class InteractiveFormCommand extends Command implements FormBasedCommand
{
    use FormBasedCommandCapabilities;
}
