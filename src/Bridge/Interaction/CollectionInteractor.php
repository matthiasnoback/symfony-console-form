<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\FormNotReadyForInteraction;
use Matthias\SymfonyConsoleForm\Console\Formatter\Format;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use RuntimeException;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormInterface;

final class CollectionInteractor implements FormInteractor
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

        $config = $form->getConfig();
        $data = $form->getData() ?: $config->getEmptyData();

        if (!$config->getOption('allow_add') && empty($data)) {
            throw new FormNotReadyForInteraction(
                'The "collection" form should have the option "allow_add" or have existing entries'
            );
        }

        if (!is_iterable($data)) {
            throw new FormNotReadyForInteraction(
                'The "collection" form must be iterable'
            );
        }

        $this->printHeader($form, $output);

        $submittedData = [];
        $prototype = $config->getAttribute('prototype');
        $originalData = $prototype->getData();

        $askIfEntryNeedsToBeSubmitted = function ($entryNumber) use ($helperSet, $input, $output) {
            return $this->askIfExistingEntryShouldBeAdded($helperSet, $input, $output, $entryNumber);
        };

        foreach ($data as $key => $entryData) {
            $this->printEditEntryHeader($key, $output);
            $prototype->setData($entryData);

            $submittedEntry = $this->formInteractor->interactWith($prototype, $helperSet, $input, $output);
            if (!$config->getOption('allow_delete') || $askIfEntryNeedsToBeSubmitted($key)) {
                $submittedData[] = $submittedEntry;
            }
        }

        if ($config->getOption('allow_add')) {
            // reset the prototype
            $prototype->setData($originalData);
            $key = count($submittedData) - 1;
            while ($this->askIfContinueToAdd($helperSet, $input, $output)) {
                $this->printAddEntryHeader(++$key, $output);
                $submittedData[] = $this->formInteractor->interactWith($prototype, $helperSet, $input, $output);
            }
        }

        return $submittedData;
    }

    private function askIfContinueToAdd(
        HelperSet $helperSet,
        InputInterface $input,
        OutputInterface $output
    ): string {
        return $this->questionHelper($helperSet)->ask(
            $input,
            $output,
            new ConfirmationQuestion(
                Format::forQuestion('Add another entry to this collection?', 'n'),
                false
            )
        );
    }

    private function questionHelper(HelperSet $helperSet): QuestionHelper
    {
        $helper = $helperSet->get('question');

        if (!$helper instanceof QuestionHelper) {
            throw new RuntimeException('HelperSet does not contain valid QuestionHelper');
        }

        return $helper;
    }

    private function printHeader(FormInterface $form, OutputInterface $output): void
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

    private function printEditEntryHeader(int $entryNumber, OutputInterface $output): void
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

    private function printAddEntryHeader(int $entryNumber, OutputInterface $output): void
    {
        $output->writeln(
            strtr(
                '<fieldset>Add entry {entryNumber}</fieldset>',
                [
                    '{entryNumber}' => $entryNumber,
                ]
            )
        );
    }

    private function askIfExistingEntryShouldBeAdded(
        HelperSet $helperSet,
        InputInterface $input,
        OutputInterface $output,
        int $entryNumber
    ): string {
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
