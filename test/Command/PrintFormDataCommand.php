<?php

namespace Matthias\SymfonyConsoleForm\Tests\Command;

use Matthias\SymfonyConsoleForm\Console\Command\DynamicFormBasedCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PrintFormDataCommand extends DynamicFormBasedCommand
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $formData = $this->formData();

        if (is_object($formData) && method_exists($formData, '__toString')) {
            $printData = $formData->__toString();
        } else {
            $printData = print_r(
                    array_map(function ($data) {
                    if ($data instanceof \DateTime) {
                        return $data->format(\DateTime::ISO8601);
                    }

                    return $data;
                }, (array)$formData),
            true
            );
        }

        $output->write($printData);

        return 0;
    }
}
