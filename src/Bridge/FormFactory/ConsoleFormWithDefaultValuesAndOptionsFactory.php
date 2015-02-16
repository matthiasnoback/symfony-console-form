<?php

namespace Matthias\SymfonyConsoleForm\Bridge\FormFactory;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Form\Extension\Csrf\Type\FormTypeCsrfExtension;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormRegistryInterface;
use Symfony\Component\Form\Test\FormBuilderInterface;

class ConsoleFormWithDefaultValuesAndOptionsFactory implements ConsoleFormFactory
{
    private $formFactory;
    private $formRegistry;

    public function __construct(FormFactoryInterface $formFactory, FormRegistryInterface $formRegistry)
    {
        $this->formFactory = $formFactory;
        $this->formRegistry = $formRegistry;
    }

    public function create($formType, InputInterface $input, array $options = [])
    {
        $options = $this->addDefaultOptions($options);

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

    private function addDefaultOptions(array $options)
    {
        $defaultOptions = array();

        // hack to prevent validation error "The CSRF token is invalid."
        foreach ($this->formRegistry->getExtensions() as $extension) {
            foreach ($extension->getTypeExtensions('form') as $typeExtension) {
                if ($typeExtension instanceof FormTypeCsrfExtension) {
                    $defaultOptions['csrf_protection'] = false;
                }
            }
        }

        return array_replace(
            $defaultOptions,
            $options
        );
    }
}
