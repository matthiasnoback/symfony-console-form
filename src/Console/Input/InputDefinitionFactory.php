<?php

namespace Matthias\SymfonyConsoleForm\Console\Input;

interface InputDefinitionFactory
{
    public function createForFormType($formType, array &$resources = []);
}
