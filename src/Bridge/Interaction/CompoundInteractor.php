<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormInterface;

class CompoundInteractor implements FormInteractor
{
    private $fieldInteractor;

    public function __construct(FormInteractor $fieldInteractor)
    {
        $this->fieldInteractor = $fieldInteractor;
    }

    public function interactWith(
        FormInterface $form,
        HelperSet $helperSet,
        InputInterface $input,
        OutputInterface $output
    ) {
        if (!FormUtil::isCompound($form)) {
            throw new CanNotInteractWithForm('Expected a compound form');
        }

        $submittedData = [];

        foreach ($form->all() as $name => $field) {
            $submittedData[$name] = $this->fieldInteractor->interactWith($field, $helperSet, $input, $output);
        }

        return $submittedData;
    }
}
