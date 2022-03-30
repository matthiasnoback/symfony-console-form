<?php

namespace Matthias\SymfonyConsoleForm\Bridge\FormFactory;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Form\FormInterface;

interface ConsoleFormFactory
{
    public function create(string $formType, InputInterface $input, array $options = []): FormInterface;

    public function createNamed(string $name, string $formType, InputInterface $input, array $options = []): FormInterface;
}
