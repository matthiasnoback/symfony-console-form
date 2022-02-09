<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormInterface;

final class NonInteractiveRootInteractor implements FormInteractor
{
    /**
     * @throws CanNotInteractWithForm If isn't a root form or is the input is interactive
     *
     * @return InputInterface
     */
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

        /*
         * We need to adjust the input values for repeated types by copying the provided value to both of the
         * repeated fields.
         *
         * The fix was provided by @craigh
         *
         * P.S. If we need to add another fix like this, we should move this out to dedicated "input fixer" classes.
         */
        $this->fixInputForField($input, $form);

        // use the original input as the submitted data
        return $input;
    }

    private function fixInputForField(InputInterface $input, FormInterface $form, ?string $name = null): void
    {
        $config = $form->getConfig();
        $isRepeatedField = $config->getType()->getInnerType() instanceof RepeatedType;
        if (!$isRepeatedField && $config->getCompound()) {
            foreach ($form->all() as $childName => $field) {
                $subName = $name === null ? $childName : $name . '[' . $childName . ']';
                $this->fixInputForField($input, $field, $subName);
            }
        } else {
            $name = $name ?? $form->getName();
            if ($isRepeatedField && $input->hasOption($name)) {
                $input->setOption($name, [
                    $config->getOption('first_name') => $input->getOption($name),
                    $config->getOption('second_name') => $input->getOption($name),
                ]);
            }
        }
    }
}
