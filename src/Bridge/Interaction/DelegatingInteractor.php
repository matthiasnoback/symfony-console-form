<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormInterface;

class DelegatingInteractor implements FormInteractor, FormJsonTemplateInterface
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
                if ($interactor instanceof FormInteractor) {
                    return $interactor->interactWith($form, $helperSet, $input, $output);
                }
            } catch (CanNotInteractWithForm $exception) {
                continue;
            }
        }

        throw new CanNotInteractWithForm('No delegate was able to interact with this form');
    }

    /**
     * @param FormInterface $form
     *
     * @return mixed
     */
    public function getAttributesWithFakeData(FormInterface $form)
    {
        foreach ($this->delegates as $interactor) {
            try {
                if ($interactor instanceof FormJsonTemplateInterface) {
                    return $interactor->getAttributesWithFakeData($form);
                }
            } catch (CanNotInteractWithForm $exception) {
                continue;
            }
        }

        throw new CanNotInteractWithForm('No delegate was able to interact with this form');
    }
}
