<?php

namespace Matthias\SymfonyConsoleForm\Console\Helper;

use Matthias\SymfonyConsoleForm\Bridge\FormFactory\ConsoleFormFactory;
use Matthias\SymfonyConsoleForm\Bridge\Interaction\FormInteractor;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

class FormHelper extends Helper
{
    private $formFactory;
    private $formInteractor;

    /**
     * @return string
     */
    public function getName()
    {
        return 'form';
    }

    /**
     * @param ConsoleFormFactory $formFactory
     * @param FormInteractor     $formInteractor
     */
    public function __construct(
        ConsoleFormFactory $formFactory,
        FormInteractor $formInteractor
    ) {
        $this->formFactory = $formFactory;
        $this->formInteractor = $formInteractor;
    }

    /**
     * @param string|\Symfony\Component\Form\FormTypeInterface $formType
     * @param InputInterface                                   $input
     * @param OutputInterface                                  $output
     * @param array                                            $options
     *
     * @return mixed
     */
    public function interactUsingForm($formType, InputInterface $input, OutputInterface $output, array $options = [])
    {
        $form = $this->formFactory->create($formType, $input, $options);

        $submittedData = $this->formInteractor->interactWith($form, $this->getHelperSet(), $input, $output);

        $form->submit($submittedData);
        if (!$form->isValid()) {
            $this->invalidForm($form);
        }

        return $form->getData();
    }

    /**
     * @param FormInterface $form
     *
     * @throws \RuntimeException
     */
    private function invalidForm(FormInterface $form)
    {
        $msg = "Invalid data provided:\n";
        $template = '- Form: %1$s, Field: %2$s, Reason: %3$s'."\n";

        /** @var $val FormError */
        foreach ($form->getErrors(true) as $val) {
            $msg .= sprintf($template, $form->getName(), $val->getOrigin()->getName(), $val->getMessage());
        }

        throw new \RuntimeException($msg);
    }
}
