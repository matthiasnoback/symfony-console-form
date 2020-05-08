<?php

namespace Matthias\SymfonyConsoleForm\Console\Input;

use Symfony\Component\Console\Input\InputDefinition;

interface InputDefinitionFactory
{
    public function createForFormType(string $formType, array &$resources = []): InputDefinition;
}
