<?php

namespace Matthias\SymfonyConsoleForm\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractInteractiveFormHelperContainerAwareCommand extends Command
{
    abstract protected function configureCommand();

    final protected function configure()
    {
        $this->configureCommand();

        foreach (FormConsoleOptions::getBasicOptions() as $inputOption) {
            $this->addOption(
                $inputOption->getName(),
                $inputOption->getShortcut(),
                $inputOption->isValueOptional() ? InputOption::VALUE_OPTIONAL : InputOption::VALUE_REQUIRED,
                $inputOption->getDescription(),
                $inputOption->getDefault()
            );
        }
    }
}
