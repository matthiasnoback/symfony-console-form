<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\NoNeedToInteractWithForm;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormInterface;

final class FieldWithNoInteractionInteractor implements FormInteractor
{
    /**
     * @throws NoNeedToInteractWithForm
     * @throws CanNotInteractWithForm
     */
    public function interactWith(
        FormInterface $form,
        HelperSet $helperSet,
        InputInterface $input,
        OutputInterface $output
    ) {
        if (FormUtil::isTypeInAncestry($form, ButtonType::class)) {
            throw new NoNeedToInteractWithForm();
        }

        // by default, we let another interactor interact with this form
        throw new CanNotInteractWithForm();
    }
}
