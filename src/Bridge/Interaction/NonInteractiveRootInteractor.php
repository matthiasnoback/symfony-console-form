<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Interaction;

use Matthias\SymfonyConsoleForm\Bridge\Interaction\Exception\CanNotInteractWithForm;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormInterface;

class NonInteractiveRootInteractor implements FormInteractor
{
    /**
     * @param FormInterface   $form
     * @param HelperSet       $helperSet
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws CanNotInteractWithForm If isn't a root form or is the input is interactive.
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
         * We need to adjust the input values for repeated types by copying the provided value to both of the repeated
         * fields. We only loop through the top-level fields, since there are no command options for deeper lying fields
         * anyway.
         *
         * The fix was provided by @craigh
         *
         * P.S. If we need to add another fix like this, we should move this out to dedicated "input fixer" classes.
         */
        foreach ($form->all() as $child) {
            $config = $child->getConfig();
            $name = $child->getName();
            if ($config->getType()->getInnerType() instanceof RepeatedType && $input->hasOption($name)) {
                $input->setOption($name, [
                    $config->getOption('first_name') => $input->getOption($name),
                    $config->getOption('second_name') => $input->getOption($name),
                ]);
            }
        }

        // use the original input as the submitted data
        return $input;
    }
}
