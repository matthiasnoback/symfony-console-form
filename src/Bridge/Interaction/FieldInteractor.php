<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Matthias\SymfonyConsoleForm\Bridge\Transformer\FormToQuestionTransformer;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormInterface;

class FieldInteractor implements FormInteractor
{
    /** @var FormToQuestionTransformer[] */
    private $transformers = array();

    public function addTransformer($formType, FormToQuestionTransformer $transformer)
    {
        $this->transformers[$formType] = $transformer;
    }

    public function interactWith(
        FormInterface $form,
        QuestionHelper $questionHelper,
        InputInterface $input,
        OutputInterface $output
    ) {
        $fieldType = $form->getConfig()->getType()->getName();

        $question = $this->getTransformerFor($fieldType)->transform($form);

        return $questionHelper->ask($input, $output, $question);
    }

    private function getTransformerFor($fieldType)
    {
        if (!isset($this->transformers[$fieldType])) {
            throw new CanNotInteractWithForm("No transformer exists for field type '$fieldType'");
        }

        return $this->transformers[$fieldType];
    }
}
