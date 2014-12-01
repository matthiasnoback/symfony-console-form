<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class InteractiveFormContainerAwareCommand extends ContainerAwareCommand implements FormBasedCommand
{
    use FormBasedCommandCapabilities;
}
