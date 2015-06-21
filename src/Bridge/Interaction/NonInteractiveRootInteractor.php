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

        // Make sure to adjust input for repeated types.
        foreach ($form->all() as $child) {
            $config = $child->getConfig();
            $name = $child->getName();
            if ($config->getType()->getInnerType() instanceof RepeatedType && $input->hasOption('name')) {
                $input->setOption($name, [
                    $config->getOption('first_name') => $input->getOption($name),
                    $config->getOption('second_name') => $input->getOption($name)
                ]);
            }
        }

        // use the original input as the submitted data
        return $input;
    }
}
