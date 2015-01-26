<?php

namespace Matthias\SymfonyConsoleForm\Bridge\FormFactory;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Test\FormBuilderInterface;

class ConsoleFormWithDefaultValuesFactory implements ConsoleFormFactory
{
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function create($formType, InputInterface $input, array $options = [])
    {
        $formBuilder = $this->formFactory->createBuilder($formType, null, $options);

        foreach ($formBuilder as $name => $childBuilder) {
            /** @var FormBuilderInterface $childBuilder */
            if (!$input->hasOption($name)) {
                continue;
            }

            $providedValue = $input->getOption($name);
            if ($providedValue === null) {
                continue;
            }

            $childBuilder->setData($providedValue);
        }

        return $formBuilder->getForm();
    }
}
