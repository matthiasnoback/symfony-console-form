<?php

namespace Matthias\SymfonyConsoleForm\Console\EventListener;

use Matthias\SymfonyConsoleForm\Console\Command\FormBasedCommand;
use Matthias\SymfonyConsoleForm\Console\Helper\FormQuestionHelper;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

class HandleFormBasedCommandEventListener
{
    private $formQuestionHelper;

    public function __construct(FormQuestionHelper $formQuestionHelper)
    {
        $this->formQuestionHelper = $formQuestionHelper;
    }

    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        $command = $event->getCommand();
        if (!($command instanceof FormBasedCommand)) {
            return;
        }

        $input = $event->getInput();
        $output = $event->getOutput();

        $formData = $this->formQuestionHelper->interactUsingForm($command->formType(), $input, $output);

        $command->setFormData($formData);
    }
}
