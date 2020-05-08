<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Matthias\SymfonyConsoleForm\Bridge\Transformer\TransformerResolver;
use RuntimeException;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormInterface;

class FieldInteractor implements FormInteractor
{
    /**
     * @var TransformerResolver
     */
    private $transformerResolver;

    /**
     * @param TransformerResolver $transformerResolver
     */
    public function __construct(TransformerResolver $transformerResolver)
    {
        $this->transformerResolver = $transformerResolver;
    }

    /**
     * @throws CanNotInteractWithForm The input isn't interactive
     *
     * @return mixed
     */
    public function interactWith(
        FormInterface $form,
        HelperSet $helperSet,
        InputInterface $input,
        OutputInterface $output
    ) {
        if (!$input->isInteractive()) {
            throw new CanNotInteractWithForm('This interactor only works with interactive input');
        }

        $question = $this->transformerResolver->resolve($form)->transform($form);

        return $this->questionHelper($helperSet)->ask($input, $output, $question);
    }

    private function questionHelper(HelperSet $helperSet): QuestionHelper
    {
        $helper = $helperSet->get('question');

        if (!$helper instanceof QuestionHelper) {
            throw new RuntimeException('HelperSet does not contain valid QuestionHelper');
        }

        return $helper;
    }
}
