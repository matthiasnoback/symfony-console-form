<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\NoNeedToInteractWithForm;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormInterface;

class CompoundInteractor implements FormInteractor, FormJsonTemplateInterface
{
    /**
     * @var FormInteractor|FormJsonTemplateInterface
     */
    private $formInteractor;

    /**
     * @param FormInteractor|FormJsonTemplateInterface $formInteractor
     */
    public function __construct(FormInteractor $formInteractor)
    {
        $this->formInteractor = $formInteractor;
    }

    /**
     * @param FormInterface   $form
     * @param HelperSet       $helperSet
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws CanNotInteractWithForm If the input isn't interactive or a compound form.
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

        $this->formRequirements($form);

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

    private function formRequirements(FormInterface $form)
    {
        if (!FormUtil::isCompound($form)) {
            throw new CanNotInteractWithForm('Expected a compound form');
        }
    }

    /**
     * @param FormInterface $form
     *
     * @return mixed
     */
    public function getAttributesWithFakeData(FormInterface $form)
    {
        $this->formRequirements($form);

        $submittedData = [];

        foreach ($form->all() as $name => $field) {
            try {
                $submittedData[$name] = $this->formInteractor->getAttributesWithFakeData($field);
            } catch (NoNeedToInteractWithForm $exception) {
                continue;
            }
        }

        return $submittedData;
    }
}
