<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\NoNeedToInteractWithForm;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormInterface;

class CompoundInteractor implements FormInteractor
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
        if (!$input->isInteractive()) {
            throw new CanNotInteractWithForm('This interactor only works with interactive input');
        }

        if (!FormUtil::isCompound($form)) {
            throw new CanNotInteractWithForm('Expected a compound form');
        }

        $submittedData = [];

        foreach ($form->all() as $name => $field) {
            try {
                $submittedData[$name] = $this->formInteractor->interactWith($field, $helperSet, $input, $output);
            } catch (NoNeedToInteractWithForm $exception) {
                continue;
            }
        }

        return $submittedData;
    }
}
