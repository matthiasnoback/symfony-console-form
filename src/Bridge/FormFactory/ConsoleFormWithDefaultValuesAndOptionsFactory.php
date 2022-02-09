<?php

namespace Matthias\SymfonyConsoleForm\Bridge\FormFactory;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Csrf\Type\FormTypeCsrfExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormRegistryInterface;

final class ConsoleFormWithDefaultValuesAndOptionsFactory implements ConsoleFormFactory
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var FormRegistryInterface
     */
    private $formRegistry;

    public function __construct(FormFactoryInterface $formFactory, FormRegistryInterface $formRegistry)
    {
        $this->formFactory = $formFactory;
        $this->formRegistry = $formRegistry;
    }

    public function createNamed(
        string $name,
        string $formType,
        InputInterface $input,
        array $options = []
    ): FormInterface {
        $options = $this->addDefaultOptions($options);

        $formBuilder = $this->formFactory->createNamedBuilder($name, $formType, null, $options);

        $this->createChild($formBuilder, $input, $options);

        return $formBuilder->getForm();
    }

    public function create(string $formType, InputInterface $input, array $options = []): FormInterface
    {
        $options = $this->addDefaultOptions($options);

        $formBuilder = $this->formFactory->createBuilder($formType, null, $options);

        $this->createChild($formBuilder, $input, $options);

        return $formBuilder->getForm();
    }

    protected function createChild(
        FormBuilderInterface $formBuilder,
        InputInterface $input,
        array $options,
        ?string $name = null
    ): void {
        if ($formBuilder->getCompound()) {
            /** @var FormBuilderInterface $childBuilder */
            foreach ($formBuilder as $childName => $childBuilder) {
                $this->createChild(
                    $childBuilder,
                    $input,
                    $options,
                    $name === null ? $childName : $name . '[' . $childName . ']'
                );
            }
        } else {
            $name = $name ?? $formBuilder->getName();
            if (!$input->hasOption($name)) {
                return;
            }

            $providedValue = $input->getOption($name);
            if ($providedValue === null) {
                return;
            }

            $value = $providedValue;
            try {
                foreach ($formBuilder->getViewTransformers() as $viewTransformer) {
                    $value = $viewTransformer->reverseTransform($value);
                }
                foreach ($formBuilder->getModelTransformers() as $modelTransformer) {
                    $value = $modelTransformer->reverseTransform($value);
                }
            } catch (TransformationFailedException) {
            }

            $formBuilder->setData($value);
        }
    }

    private function addDefaultOptions(array $options): array
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
