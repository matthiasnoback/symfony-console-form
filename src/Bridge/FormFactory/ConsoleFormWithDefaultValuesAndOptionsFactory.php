<?php

namespace Matthias\SymfonyConsoleForm\Bridge\FormFactory;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Csrf\Type\FormTypeCsrfExtension;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormRegistryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Test\FormBuilderInterface;

class ConsoleFormWithDefaultValuesAndOptionsFactory implements ConsoleFormFactory
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var FormRegistryInterface
     */
    private $formRegistry;

    /**
     * @param FormFactoryInterface  $formFactory
     * @param FormRegistryInterface $formRegistry
     */
    public function __construct(FormFactoryInterface $formFactory, FormRegistryInterface $formRegistry)
    {
        $this->formFactory = $formFactory;
        $this->formRegistry = $formRegistry;
    }

    /**
     * @param string|FormTypeInterface $formType
     * @param InputInterface           $input
     * @param array                    $options
     *
     * @return \Symfony\Component\Form\Form
     */
    public function create($formType, InputInterface $input, array $options = [])
    {
        $options = $this->addDefaultOptions($options);

        $class = $formType;
        if ($class instanceof FormTypeInterface) {
            $class = get_class($formType);
        }

        $formBuilder = $this->formFactory->createBuilder($class, null, $options);

        foreach ($formBuilder as $name => $childBuilder) {
            /* @var FormBuilderInterface $childBuilder */
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

    /**
     * @param array $options
     *
     * @return array
     */
    private function addDefaultOptions(array $options)
    {
        $defaultOptions = [];
        // hack to prevent validation error "The CSRF token is invalid."
        foreach ($this->formRegistry->getExtensions() as $extension) {
            foreach ($extension->getTypeExtensions(FormType::class) as $typeExtension) {
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
