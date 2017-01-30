<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\FormNotReadyForInteraction;
use Matthias\SymfonyConsoleForm\Console\Formatter\Format;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
     * @throws CanNotInteractWithForm     If the input isn't interactive
     * @throws FormNotReadyForInteraction If the "collection" form hasn't the option "allow_add"
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

        if (!FormUtil::isTypeInAncestry($form, CollectionType::class)) {
            throw new CanNotInteractWithForm('Expected a "collection" form');
        }

        if (!$form->getConfig()->getOption('allow_add')) {
            throw new FormNotReadyForInteraction('The "collection" form should have the option "allow_add"');
        }

        $this->printHeader($form, $output);

        $submittedData = [];
        $prototype = $form->getConfig()->getAttribute('prototype');
        $askIfEntryNeedsToBeSubmitted = function ($entryNumber) use ($helperSet, $input, $output) {
            return $this->askIfExistingEntryShouldBeAdded($helperSet, $input, $output, $entryNumber);
        };

        foreach ((array) $form->getData() as $key => $entryData) {
            $this->printEntryHeader($key, $output);
            $prototype->setData($entryData);

            $submittedEntry = $this->formInteractor->interactWith($prototype, $helperSet, $input, $output);
            if (!$form->getConfig()->getOption('allow_delete') || $askIfEntryNeedsToBeSubmitted($key)) {
                $submittedData[] = $submittedEntry;
            }
        }

        if ($form->getConfig()->getOption('allow_add')) {
            while ($this->askIfContinueToAdd($helperSet, $input, $output)) {
                $submittedData[] = $this->formInteractor->interactWith($prototype, $helperSet, $input, $output);
            }
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
                    '{label}' => FormUtil::label($form),
                ]
            )
        );
    }

    /**
     * @param int             $entryNumber
     * @param OutputInterface $output
     */
    private function printEntryHeader($entryNumber, OutputInterface $output)
    {
        $output->writeln(
            strtr(
                '<fieldset>Edit entry {entryNumber}</fieldset>',
                [
                    '{entryNumber}' => $entryNumber,
                ]
            )
        );
    }

    /**
     * @param HelperSet       $helperSet
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param int             $entryNumber
     *
     * @return string
     */
    private function askIfExistingEntryShouldBeAdded(
        HelperSet $helperSet,
        InputInterface $input,
        OutputInterface $output,
        $entryNumber
    ) {
        return $this->questionHelper($helperSet)->ask(
            $input,
            $output,
            new ConfirmationQuestion(
                Format::forQuestion(
                    strtr(
                        'Add entry {entryNumber} to the submitted entries?',
                        [
                            '{entryNumber}' => $entryNumber,
                        ]
                    ),
                    'y'
                ),
                true
            )
        );
    }
}
