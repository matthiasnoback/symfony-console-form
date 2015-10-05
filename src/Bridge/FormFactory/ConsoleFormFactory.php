<?php

namespace Matthias\SymfonyConsoleForm\Bridge\FormFactory;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Form\FormInterface;

interface ConsoleFormFactory
{
    /**
     * @param string|FormTypeInterface $formType
     * @param InputInterface           $input
     * @param array                    $options
     * 
     * @return FormInterface
     */
    public function create($formType, InputInterface $input, array $options = []);
}
