<?php

namespace Matthias\SymfonyConsoleForm\Bridge\FormFactory;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Form\FormInterface;

interface ConsoleFormFactory
{
    /**
     * @return FormInterface
     */
    public function create($formType, InputInterface $input);
}
