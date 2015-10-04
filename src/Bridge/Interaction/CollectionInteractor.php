<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Console\Formatter\Format;
use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\FormNotReadyForInteraction;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Form\FormInterface;

class CollectionInteractor implements FormInteractor
{
    /**
     * @var FormInteractor
     */
    private $formInteractor;

    /**
     * @param FormInteractor $formInteractor
     */
    public function __construct(FormInteractor $formInteractor)
    {
        $this->formInteractor = $formInteractor;
    }

    /**
     * @param FormInterface   $form
     * @param HelperSet       $helperSet
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws CanNotInteractWithForm     If the input isn't interactive.
     * @throws FormNotReadyForInteraction If the "collection" form hasn't the option "allow_add".
     *
     * @return array
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

        if (!FormUtil::isTypeInAncestry($form, 'collection')) {
            throw new CanNotInteractWithForm('Expected a "collection" form');
        }

        if (!$form->getConfig()->getOption('allow_add')) {
            throw new FormNotReadyForInteraction('The "collection" form should have the option "allow_add"');
        }

        $this->printHeader($form, $output);

        $submittedData = [];
        $prototype = $form->getConfig()->getAttribute('prototype');

        while ($this->askIfContinueToAdd($helperSet, $input, $output)) {
            $submittedData[] = $this->formInteractor->interactWith($prototype, $helperSet, $input, $output);
        }

        return $submittedData;
    }

    /**
     * @param HelperSet       $helperSet
     * @param InputInterface  $input
     * @param OutputInterface $output
     * 
     * @return string
     */
    private function askIfContinueToAdd(
        HelperSet $helperSet,
        InputInterface $input,
        OutputInterface $output
    ) {
        return $this->questionHelper($helperSet)->ask(
            $input,
            $output,
            new ConfirmationQuestion(
                Format::forQuestion('Add another entry to this collection?', 'n'),
                false
            )
        );
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
     * @param FormInterface   $form
     * @param OutputInterface $output
     */
    private function printHeader(FormInterface $form, OutputInterface $output)
    {
        $output->writeln(
            strtr(
                '<fieldset>{label}</fieldset>',
                [
                    '{label}' => FormUtil::label($form)
                ]
            )
        );
    }
}
