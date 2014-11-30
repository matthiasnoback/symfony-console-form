<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormInterface;

class RootInteractor implements FormInteractor
{
    private $fieldInteractor;

    public function __construct(FormInteractor $fieldInteractor)
    {
        $this->fieldInteractor = $fieldInteractor;
    }

    public function interactWith(
        FormInterface $form,
        QuestionHelper $questionHelper,
        InputInterface $input,
        OutputInterface $output
    ) {
        if (!$form->isRoot()) {
            throw new CanNotInteractWithForm('Expected a root form');
        }

        $submittedData = [];

        foreach ($form->all() as $name => $field) {
            $submittedData[$name] = $this->fieldInteractor->interactWith($field, $questionHelper, $input, $output);
        }

        return $submittedData;
    }
}
