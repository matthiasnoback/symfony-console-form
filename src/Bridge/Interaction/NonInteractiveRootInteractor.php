<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormInterface;

class NonInteractiveRootInteractor implements FormInteractor
{
    public function interactWith(
        FormInterface $form,
        HelperSet $helperSet,
        InputInterface $input,
        OutputInterface $output
    ) {
        if (!$form->isRoot()) {
            throw new CanNotInteractWithForm('This interactor only works with root forms');
        }

        if ($input->isInteractive()) {
            throw new CanNotInteractWithForm('This interactor only works with non-interactive input');
        }

        // use the original input as the submitted data
        return $input;
    }
}
