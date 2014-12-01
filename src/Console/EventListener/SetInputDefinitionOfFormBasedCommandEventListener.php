<?php

namespace Matthias\SymfonyConsoleForm\Console\EventListener;

use Matthias\SymfonyConsoleForm\Console\Command\FormBasedCommand;
use Matthias\SymfonyConsoleForm\Console\Input\InputDefinitionFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\InputInterface;

class SetInputDefinitionOfFormBasedCommandEventListener
{
    private $inputDefinitionFactory;

    public function __construct(InputDefinitionFactory $inputDefinitionFactory)
    {
        $this->inputDefinitionFactory = $inputDefinitionFactory;
    }

    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        $command = $event->getCommand();

        if (!($command instanceof FormBasedCommand)) {
            return;
        }

        $this->createAndSetInputDefinition($command, $event->getInput());
    }

    private function createAndSetInputDefinition(Command $command, InputInterface $input)
    {
        $inputDefinition = $this->inputDefinitionFactory->createForCommand($command);

        $command->setDefinition($inputDefinition);
        $command->mergeApplicationDefinition();
        $input->bind($inputDefinition);
    }
}
