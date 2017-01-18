<?php

namespace Matthias\SymfonyConsoleForm\Tests\Command;

use Matthias\SymfonyConsoleForm\Console\Command\DynamicFormBasedCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PrintFormDataCommand extends DynamicFormBasedCommand
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formData = $this->formData();

        $printData = array_map(function ($data) {
            if ($data instanceof \DateTime) {
                return $data->format(\DateTime::ISO8601);
            }

            return $data;
        }, $formData);

        $output->write(print_r($printData, true));
    }
}
