<?php

namespace Matthias\SymfonyConsoleForm\Console\Input;

use Matthias\SymfonyConsoleForm\Console\Command\FormBasedCommand;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class FormBasedInputDefinitionFactory implements InputDefinitionFactory
{
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function createForCommand(Command $command, array &$resources = [])
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

        foreach ($form->all() as $name => $field) {
            if (!$this->isFormFieldSupported($field)) {
                continue;
            }

            $type = InputOption::VALUE_REQUIRED;
            $default = $field->getConfig()->getOption('data', null);
            $description = FormUtil::label($field);

            $inputDefinition->addOption(new InputOption($name, null, $type, $description, $default));
        }

        return $inputDefinition;
    }

    private function isFormFieldSupported(FormInterface $field)
    {
        if ($field->getConfig()->getCompound()) {
            return false;
        }

        return true;
    }
}
