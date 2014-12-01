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
    private $formInteractor;

    public function __construct(FormInteractor $formInteractor)
    {
        $this->formInteractor = $formInteractor;
    }

    public function interactWith(
        FormInterface $form,
        HelperSet $helperSet,
        InputInterface $input,
        OutputInterface $output
    ) {
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
     * @return QuestionHelper
     */
    private function questionHelper(HelperSet $helperSet)
    {
        return $helperSet->get('question');
    }

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
