<?php

namespace Matthias\SymfonyConsoleForm\Console\Helper;

use Matthias\SymfonyConsoleForm\Bridge\FormFactory\ConsoleFormFactory;
use Matthias\SymfonyConsoleForm\Bridge\Interaction\FormInteractor;
use RuntimeException;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

class FormHelper extends Helper
{
    private $formFactory;
    private $formInteractor;

    public function getName(): string
    {
        return 'form';
    }

    public function __construct(
        ConsoleFormFactory $formFactory,
        FormInteractor $formInteractor
    ) {
        $this->formFactory = $formFactory;
        $this->formInteractor = $formInteractor;
    }

    /**
     * @param mixed $data
     *
     * @return mixed
     */
    public function interactUsingForm(
        string $formType,
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
                $formErrors = $form->getErrors(true, false);
                $output->write(sprintf('Invalid data provided: %s', $formErrors));
                if ($this->noErrorsCanBeFixed($formErrors)) {
                    $violationPaths = $this->constraintViolationPaths($formErrors);
                    $hint = (count($violationPaths) > 0 ? ' (Violations on unused fields: '.implode(', ', $violationPaths).')' : '');
                    throw new RuntimeException(
                        'Errors out of the form\'s scope - do you have validation constraints on properties not used in the form?'
                        . $hint
                    );
                }
                array_map(
                    function (FormInterface $formField) use (&$validFormFields) {
                        if ($formField->isValid()) {
                            $validFormFields[] = $formField->getName();
                        }
                    },
                    $form->all()
                );

                if (!$input->isInteractive()) {
                    throw new RuntimeException('There were form errors.');
                }
            }
        } while (!$form->isValid());

        return $data;
    }

    protected function noErrorsCanBeFixed(FormErrorIterator $errors): bool
    {
        // none of the remaining errors is related to a value of a form field
        return $errors->count() > 0 &&
            0 === count(array_filter(iterator_to_array($errors), function ($error) {
                return $error instanceof FormErrorIterator;
            }));
    }

    protected function constraintViolationPaths(FormErrorIterator $errors): array
    {
        $paths = [];
        foreach ($errors as $error) {
            if (!$error instanceof FormError) {
                continue;
            }
            $cause = $error->getCause();
            if (!$cause instanceof ConstraintViolationInterface) {
                continue;
            }
            $paths[] = $cause->getPropertyPath();
        }

        return $paths;
    }
}
