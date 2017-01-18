<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormInterface;

class DelegatingInteractor implements FormInteractor
{
    /**
     * @var FormInteractor[]
     */
    private $delegates = [];

    /**
     * @param FormInteractor $interactor
     */
    public function addInteractor(FormInteractor $interactor)
    {
        $this->delegates[] = $interactor;
    }

    /**
     * @param FormInterface   $form
     * @param HelperSet       $helperSet
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws CanNotInteractWithForm If no delegate was able to interact with this form
     */
    public function interactWith(
        FormInterface $form,
        HelperSet $helperSet,
        InputInterface $input,
        OutputInterface $output
    ) {
        foreach ($this->delegates as $interactor) {
            try {
                return $interactor->interactWith($form, $helperSet, $input, $output);
            } catch (CanNotInteractWithForm $exception) {
                continue;
            }
        }

        throw new CanNotInteractWithForm('No delegate was able to interact with this form');
    }
}
