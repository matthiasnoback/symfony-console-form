<?php

namespace Matthias\SymfonyConsoleForm\Console\EventListener;

use Matthias\SymfonyConsoleForm\Console\Command\FormBasedCommand;
use Matthias\SymfonyConsoleForm\Console\Input\InputDefinitionFactory;
use ReflectionObject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;

final class SetInputDefinitionOfFormBasedCommandEventListener
{
    /**
     * @var InputDefinitionFactory
     */
    private $inputDefinitionFactory;

    public function __construct(InputDefinitionFactory $inputDefinitionFactory)
    {
        $this->inputDefinitionFactory = $inputDefinitionFactory;
    }

    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        $command = $event->getCommand();
        if ($command instanceof HelpCommand) {
            $command = $this->getCommandFromHelpCommand($command);
        }

        if (!($command instanceof FormBasedCommand)) {
            return;
        }

        $inputDefinition = $this->inputDefinitionFactory->createForFormType($command->formType());
        $this->setInputDefinition($command, $event->getInput(), $inputDefinition);
    }

    private function setInputDefinition(Command $command, InputInterface $input, InputDefinition $inputDefinition): void
    {
        $command->setDefinition($inputDefinition);
        $command->mergeApplicationDefinition();
        $input->bind($inputDefinition);
    }

    private function getCommandFromHelpCommand(HelpCommand $helpCommand): ?Command
    {
        // hackish way of retrieving the command for which help was asked
        $reflectionObject = new ReflectionObject($helpCommand);
        $commandProperty = $reflectionObject->getProperty('command');
        $commandProperty->setAccessible(true);

        return $commandProperty->getValue($helpCommand);
    }
}
