<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Matthias\SymfonyConsoleForm\Bridge\Transformer\Exception\CouldNotResolveTransformer;
use Matthias\SymfonyConsoleForm\Bridge\Transformer\TransformerResolver;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormInterface;

class FieldInteractor implements FormInteractor, FormJsonTemplateInterface
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
     * @param FormInterface   $form
     * @param HelperSet       $helperSet
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws CanNotInteractWithForm The input isn't interactive
     *
     * @return string
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

    /**
     * @param HelperSet $helperSet
     *
     * @return QuestionHelper
     */
    private function questionHelper(HelperSet $helperSet)
    {
        return $helperSet->get('question');
    }

    /**
     * @param FormInterface $form
     *
     * @return array
     */
    public function getAttributesWithFakeData(FormInterface $form)
    {
        try {
            return $this->transformerResolver->resolveForFakeData($form)->getFakeData($form);
        } catch (CouldNotResolveTransformer $e) {
            return 'Unknown type';
        }
    }
}
