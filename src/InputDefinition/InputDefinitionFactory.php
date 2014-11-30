<?php

namespace Matthias\SymfonyConsoleForm\InputDefinition;

use Symfony\Component\Console\Command\Command;

interface InputDefinitionFactory
{
    public function createForCommand(Command $command, array &$resources = array());
}
