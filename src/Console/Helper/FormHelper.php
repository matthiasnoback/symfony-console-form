<?php

namespace Matthias\SymfonyConsoleForm\Console\Helper;

use Matthias\SymfonyConsoleForm\Bridge\FormFactory\ConsoleFormFactory;
use Matthias\SymfonyConsoleForm\Bridge\Interaction\FormInteractor;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
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
     * @param mixed                                            $data
     *
     * @return mixed
     */
    public function interactUsingForm(
        $formType,
        InputInterface $input,
        OutputInterface $output,
        array $options = [],
        $data = null
    ) {
        $validFormFields = [];

        do {
            $form = $this->formFactory->create($formType, $input, $options);
            $form->setData($data);

            // if we are rerunning the form for invalid data we don't need the fields that are already valid.
            foreach ($validFormFields as $validFormField) {
                $form->remove($validFormField);
            }

            $submittedData = $this->formInteractor->interactWith($form, $this->getHelperSet(), $input, $output);

            $form->submit($submittedData);

            // save the current data
            $data = $form->getData();

            if (!$form->isValid()) {
                $output->write(sprintf('Invalid data provided: %s', $form->getErrors(true, false)));
                array_map(
                    function (FormInterface $formField) use ($form, &$validFormFields) {
                        if ($formField->isValid()) {
                            $validFormFields[] = $formField->getName();
                        }
                    },
                    $form->all()
                );
            }
        } while (!$form->isValid());

        return $data;
    }
}
