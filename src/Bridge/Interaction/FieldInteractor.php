<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Transformer\TransformerResolver;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormInterface;

class FieldInteractor implements FormInteractor
{
    private $transformerResolver;

    public function __construct(TransformerResolver $transformerResolver)
    {
        $this->transformerResolver = $transformerResolver;
    }

    public function interactWith(
        FormInterface $form,
        HelperSet $helperSet,
        InputInterface $input,
        OutputInterface $output
    ) {
        $question = $this->transformerResolver->resolve($form)->transform($form);

        return $this->questionHelper($helperSet)->ask($input, $output, $question);
    }

    /**
     * @return QuestionHelper
     */
    private function questionHelper(HelperSet $helperSet)
    {
        return $helperSet->get('question');
    }
}
