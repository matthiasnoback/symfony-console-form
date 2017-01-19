<?php

namespace Matthias\SymfonyConsoleForm\Console\EventListener;

use Matthias\SymfonyConsoleForm\Console\Command\FormBasedCommand;
use Matthias\SymfonyConsoleForm\Console\Command\FormConsoleOptions;
use Matthias\SymfonyConsoleForm\Console\Input\InputDefinitionFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;

class SetInputDefinitionOfFormBasedCommandEventListener
{
    /**
     * @var InputDefinitionFactory
     */
    private $inputDefinitionFactory;

    /**
     * @param InputDefinitionFactory $inputDefinitionFactory
     */
    public function __construct(InputDefinitionFactory $inputDefinitionFactory)
    {
        $this->inputDefinitionFactory = $inputDefinitionFactory;
    }

    /**
     * @param ConsoleCommandEvent $event
     */
    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        $command = $event->getCommand();
        if ($command instanceof HelpCommand) {
            $command = $this->getCommandFromHelpCommand($command);
        }

        if (!($command instanceof FormBasedCommand)) {
            return;
        }

        $inputDefinition = $this->inputDefinitionFactory->createForFormType($command->formType());

        foreach (FormConsoleOptions::getBasicOptions() as $inputOption) {
            $inputDefinition->addOption($inputOption);
        }

        $this->setInputDefinition($command, $event->getInput(), $inputDefinition);
    }

    /**
     * @param Command         $command
     * @param InputInterface  $input
     * @param InputDefinition $inputDefinition
     */
    private function setInputDefinition(Command $command, InputInterface $input, InputDefinition $inputDefinition)
    {
        $command->setDefinition($inputDefinition);
        $command->mergeApplicationDefinition();
        $input->bind($inputDefinition);
    }

    /**
     * @param HelpCommand $helpCommand
     *
     * @return Command|null
     */
    private function getCommandFromHelpCommand(HelpCommand $helpCommand)
    {
        // hackish way of retrieving the command for which help was asked
        $reflectionObject = new \ReflectionObject($helpCommand);
        $commandProperty = $reflectionObject->getProperty('command');
        $commandProperty->setAccessible(true);

        return $commandProperty->getValue($helpCommand);
    }
}
