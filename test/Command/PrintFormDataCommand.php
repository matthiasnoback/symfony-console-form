<?php

namespace Matthias\SymfonyConsoleForm\Tests\Command;

use Matthias\SymfonyConsoleForm\Console\Command\DynamicFormBasedCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PrintFormDataCommand extends DynamicFormBasedCommand
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Matthias\SymfonyConsoleForm\Tests\Form\Data\Demo $data */
        $data = $this->formData();

        $output->write(print_r($data, true));
    }
}
