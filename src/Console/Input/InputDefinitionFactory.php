<?php

namespace Matthias\SymfonyConsoleForm\Console\Input;

use Symfony\Component\Console\Command\Command;

interface InputDefinitionFactory
{
    public function createForCommand(Command $command, array &$resources = []);
}
