<?php

namespace Matthias\SymfonyConsoleForm\Console\Helper;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\FormInteractor;
use Matthias\SymfonyConsoleForm\Form\EventListener\UseInputOptionsAsEventDataEventSubscriber;
use Matthias\SymfonyConsoleForm\Console\Input\InputDefinitionFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class FormQuestionHelper extends Helper
{
    private $formFactory;
    private $inputDefinitionFactory;
    private $formInteractor;

    public function getName()
    {
        return 'form_question';
    }

    public function __construct(
        FormFactoryInterface $formFactory,
        InputDefinitionFactory $inputDefinitionFactory,
        FormInteractor $formInteractor
    ) {
        $this->formFactory = $formFactory;
        $this->inputDefinitionFactory = $inputDefinitionFactory;
        $this->formInteractor = $formInteractor;
    }

    public function interactUsingForm($formType, InputInterface $input, OutputInterface $output)
    {
        $form = $this->createForm($formType, $input);

        $submittedData = $this->formInteractor->interactWith($form, $this->questionHelper(), $input, $output);

        $form->submit($submittedData);
        if ($form->isValid()) {
            foreach ($form as $field) {
                $input->setOption($field->getName(), $field->getData());
            }
        } else {
            $this->invalidForm($form);
        }

        return $form->getData();
    }

    public function inputDefinition(Command $command)
    {
        return $this->inputDefinitionFactory->createForCommand($command);
    }

    public function createForm($type, InputInterface $input = null)
    {
        $formBuilder = $this->formFactory->createBuilder($type);
        $formBuilder->addEventSubscriber(new UseInputOptionsAsEventDataEventSubscriber());

        if ($input instanceof InputInterface) {
            foreach ($formBuilder->all() as $name => $fieldBuilder) {
                /** @var $fieldBuilder FormBuilderInterface */
                if ($input->hasOption($name)) {
                    $fieldBuilder->setData($input->getOption($name));
                }
            }
        }

        $form = $formBuilder->getForm();

        return $form;
    }

    /**
     * @return QuestionHelper
     */
    private function questionHelper()
    {
        return $this->getHelperSet()->get('question');
    }

    public function doNotInteractWithForm($formType, $input)
    {
        $form = $this->createForm($formType);
        $form->submit($input);
        if (!$form->isValid()) {
            $this->invalidForm($form);
        }

        return $form->getData();
    }

    private function invalidForm(FormInterface $form)
    {
        throw new \RuntimeException(sprintf('Invalid data provided: %s', $form->getErrors(true, false)));
    }
}
