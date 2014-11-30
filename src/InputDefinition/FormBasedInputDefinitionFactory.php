<?php

namespace Matthias\SymfonyConsoleForm\InputDefinition;

use Matthias\SymfonyConsoleForm\Command\FormBasedCommand;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Form\FormFactoryInterface;

class FormBasedInputDefinitionFactory implements InputDefinitionFactory
{
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function createForCommand(Command $command, array &$resources = array())
    {
        if (!($command instanceof FormBasedCommand)) {
            throw new \LogicException('Command should be an instance of FormBasedCommand');
        }

        $formType = $command->formType();

        $resources[] = new FileResource(__FILE__);

        $form = $this->formFactory->create($formType);

        $actualFormType = $form->getConfig()->getType()->getInnerType();
        $reflection = new \ReflectionObject($actualFormType);
        $resources[] = new FileResource($reflection->getFileName());

        $inputDefinition = new InputDefinition();

        foreach ($form as $name => $field) {
            $type = InputOption::VALUE_REQUIRED;
            $default = $field->getConfig()->getOption('data', null);

            $inputDefinition->addOption(new InputOption($name, null, $type, null, $default));
        }

        return $inputDefinition;
    }
}
