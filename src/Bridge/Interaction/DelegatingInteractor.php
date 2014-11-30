<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormInterface;

class DelegatingInteractor implements FormInteractor
{
    /** @var FormInteractor[] */
    private $delegates = array();

    public function addInteractor(FormInteractor $interactor)
    {
        $this->delegates[] = $interactor;
    }

    public function interactWith(
        FormInterface $form,
        QuestionHelper $questionHelper,
        InputInterface $input,
        OutputInterface $output
    ) {
        $lastException = null;

        foreach ($this->delegates as $interactor) {
            try {
                return $interactor->interactWith($form, $questionHelper, $input, $output);
            } catch (CanNotInteractWithForm $exception) {
                $lastException = $exception;
                continue;
            }
        }

        throw new CanNotInteractWithForm('No delegate was able to interact with this form', null, $lastException);
    }
}
