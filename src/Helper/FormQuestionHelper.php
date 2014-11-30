<?php

namespace Matthias\SymfonyConsoleForm\Helper;

use Matthias\SymfonyConsoleForm\InputDefinition\InputDefinitionFactory;
use Matthias\SymfonyConsoleForm\Transformer\FormToQuestionTransformer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;

class FormQuestionHelper extends Helper
{
    private $formFactory;
    /** @var FormToQuestionTransformer[] */
    private $transformers = array();
    /**
     * @var InputDefinitionFactory
     */
    private $inputDefinitionFactory;

    public function getName()
    {
        return 'form_question';
    }

    public function __construct(FormFactoryInterface $formFactory, InputDefinitionFactory $inputDefinitionFactory)
    {
        $this->formFactory = $formFactory;
        $this->inputDefinitionFactory = $inputDefinitionFactory;
    }

    public function interactUsingForm($formType, InputInterface $input, OutputInterface $output)
    {
        $form = $this->createForm($formType, $input);

        $view = $form->createView();
        $submittedData = [];

        foreach ($form as $name => $field) {
            /** @var Form $field */

            $fieldView = $view[$name];
            /** @var FormView $fieldView */

            $fieldType = $field->getConfig()->getType()->getName();

            $question = $this->getTransformerFor($fieldType)->transform($field, $fieldView);

            $value = $this->questionHelper()->ask($input, $output, $question);

            $submittedData[$name] = $value;
        }

        $form->submit($submittedData);
        if ($form->isValid()) {
            foreach ($form as $field) {
                $input->setOption($field->getName(), $field->getData());
            }
        } else {
            throw new \RuntimeException(sprintf('Invalid data provided: %s', $form->getErrors(true, false)));
        }

        return $form->getData();
    }

    public function inputDefinition(Command $command)
    {
        return $this->inputDefinitionFactory->createForCommand($command);
    }

    private function createForm($type, InputInterface $input = null)
    {
        $formBuilder = $this->formFactory->createBuilder($type);

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

    public function addTransformer($formType, FormToQuestionTransformer $transformer)
    {
        $this->transformers[$formType] = $transformer;
    }

    private function getTransformerFor($fieldType)
    {
        if (!isset($this->transformers[$fieldType])) {
            throw new \InvalidArgumentException("No transformer exists for field type '$fieldType'");
        }

        return $this->transformers[$fieldType];
    }

    /**
     * @return QuestionHelper
     */
    private function questionHelper()
    {
        return $this->getHelperSet()->get('question');
    }
}
