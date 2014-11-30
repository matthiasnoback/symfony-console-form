<?php

namespace Matthias\SymfonyConsoleForm\Command;

use Matthias\SymfonyConsoleForm\Helper\FormQuestionHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class InteractiveFormContainerAwareCommand extends ContainerAwareCommand
{
    use InteractiveFormCapabilities;

    public function __construct(FormQuestionHelper $formQuestionHelper)
    {
        $this->setFormQuestionHelper($formQuestionHelper);

        parent::__construct();
    }
}
