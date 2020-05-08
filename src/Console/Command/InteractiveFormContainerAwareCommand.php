<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

abstract class InteractiveFormContainerAwareCommand extends Command implements FormBasedCommand
{
    use ContainerAwareTrait;
    use FormBasedCommandCapabilities;
}
