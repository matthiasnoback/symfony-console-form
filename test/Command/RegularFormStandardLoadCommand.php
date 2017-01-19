<?php

namespace Matthias\SymfonyConsoleForm\Tests\Command;

use Matthias\SymfonyConsoleForm\Console\Command\AbstractInteractiveFormHelperCommand;
use Matthias\SymfonyConsoleForm\Console\Helper\FormHelper;
use Matthias\SymfonyConsoleForm\Tests\Form\RegularFormType;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RegularFormStandardLoadCommand extends AbstractInteractiveFormHelperCommand
{
    protected function configureCommand()
    {
        $this
            ->setName('form:regular_form_standard_load')
            ->setDescription('This command is created manually like a regular app')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var FormHelper $formHelper */
        $formHelper = $this->getHelper('form');
        $formData = $formHelper->interactUsingForm(RegularFormType::class, $input, $output);

        $output->write(print_r($formData, true));
    }
}
